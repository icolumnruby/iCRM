<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rewards;
use App\Models\Member;
use App\Models\MemberPoints;
use App\Models\RoleUser;
use App\Models\RewardsRedemption;
use Session;
use Auth;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class RewardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $user = Auth::user();

        $rewards = Rewards::where([
                    ['rewards.deleted_at', NULL],
                    ['rewards.company_id', $user->company_id]
                ])
            ->paginate(20);

        return view('rewards.index', compact('rewards'));
    }

    /**
     * Displays the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $rewards = Rewards::leftJoin('users AS a1', 'rewards.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'rewards.last_updated_by', '=', 'a2.id')
                ->where([
                    ['rewards.id', $id],
                    ['rewards.deleted_at', NULL],
                ])
                ->first(['rewards.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('rewards.show', compact('rewards'));
    }

    /**
     * Creates a new product
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('rewards.create', compact('user'));
    }

    /**
     * Create a new reward.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $logged_in = Auth::user();
        //validate required fields
        $v = $this->validate($request, [
            'name' => 'required',
            'companyId' => 'required',
            'points' => 'required',
            'dailyLimit' => 'required',
            'monthlyLimit' => 'required',
            'memberLimit' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new member
            $rewards = new Rewards;
            $rewards->name = $request->get('name');
            $rewards->description = $request->get('description');
            $rewards->company_id = $request->get('companyId');
            $rewards->quantity = $request->get('quantity');
            $rewards->points = $request->get('points');
            $rewards->start_date = $request->get('startDate');
            $rewards->end_date = $request->get('endDate');
            $rewards->daily_limit = $request->get('dailyLimit');
            $rewards->monthly_limit = $request->get('monthlyLimit');
            $rewards->member_limit = $request->get('memberLimit');
            $rewards->is_active = $request->get('isActivated');
            $rewards->created_by = $logged_in->id;
            $rewards->last_updated_by = $logged_in->id;

            // save new branch
            $rewards->save();

            Session::flash('flash_message', 'Reward with ID ' . $rewards->id .' successfully added!');

            return $this->index();
        }
    }

    public function edit($id) {
        $rewards = Rewards::leftJoin('users AS a1', 'rewards.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'rewards.last_updated_by', '=', 'a2.id')
                ->where([
                    ['rewards.id', $id],
                    ['rewards.deleted_at', NULL],
                    ['a1.is_active', 'Y']
                ])
                ->first(['rewards.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('rewards.edit', compact('rewards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing rewards
        $rewards = Rewards::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
            'companyId' => 'required',
            'points' => 'required',
            'dailyLimit' => 'required',
            'monthlyLimit' => 'required',
            'memberLimit' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $rewards->name = $request->get('name');
            $rewards->description = $request->get('description');
            $rewards->company_id = $request->get('companyId');
            $rewards->quantity = $request->get('quantity');
            $rewards->points = $request->get('points');
            $rewards->start_date = $request->get('startDate');
            $rewards->end_date = $request->get('endDate');
            $rewards->daily_limit = $request->get('dailyLimit');
            $rewards->monthly_limit = $request->get('monthlyLimit');
            $rewards->member_limit = $request->get('memberLimit');
            $rewards->is_active = $request->get('isActivated');
            $rewards->created_by = $logged_in->id;
            $rewards->last_updated_by = $logged_in->id;

            // save new branch
            $rewards->save();

            Session::flash('flash_message', "Rewards with ID $id successfully updated!");

            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $logged_in = Auth::user();
        $rewards = Rewards::findOrFail($id);

        //update last_updated_by before deleting
        $rewards->last_updated_by = $logged_in->id;
        $rewards->save();

        $rewards->delete();

        Session::flash('flash_message', "Rewards with ID $id successfully deleted!");

        return $this->index();
    }

    public function items($memberId)
    {
        $member = Member::findOrFail($memberId);
        $rewards = Rewards::where([
                    ['rewards.company_id', $member->company_id],
                    ['rewards.deleted_at', NULL],
                    ['rewards.is_active', 'Y'],
                    ['start_date', '<=', date('Y-m-d H:i:s')],
                    ['end_date', '>=', date('Y-m-d H:i:s')],
                ])
                ->paginate(20);

        //get the member's loyalty points
        $totalPoints = MemberPoints::_getPoints($member->id);

        return view('rewards.items', compact('rewards', 'member', 'totalPoints'));
    }

    public function redeem(Request $request)
    {
        $logged_in = Auth::user();
        $reward = Rewards::findOrFail($request->get('rewardsId'));
        $member = Member::find($request->get('memberId'));
        $redeemedPts = (int) $request->get('qty') * $reward->points;

        $memberTotalPoints = MemberPoints::_getPoints($member->id);  //get the member's loyalty points

        //double check if the member has enough points for the reward item
        if ($redeemedPts <= $memberTotalPoints) {
            //save member points
            $memberPoints = new MemberPoints;
            $memberPoints->member_id = $member->id;
            $memberPoints->points = $redeemedPts;
            $memberPoints->points_balance = $memberTotalPoints - $redeemedPts;
            $memberPoints->created_by = $logged_in->id;
            $memberPoints->last_updated_by = $logged_in->id;

            $memberPoints->save();

            //save rewards redemption
            $rewardsRedemption = new RewardsRedemption;
            $rewardsRedemption->member_id = $member->id;
            $rewardsRedemption->member_points_id = $memberPoints->id;
            $rewardsRedemption->rewards_id = $reward->id;
            $rewardsRedemption->quantity = $request->get('qty');
            $rewardsRedemption->total_points = $redeemedPts;
            $rewardsRedemption->created_by = $logged_in->id;
            $rewardsRedemption->last_updated_by = $logged_in->id;

            $rewardsRedemption->save();
            Session::flash('flash_message', 'Rewards redeemed successfully!');
        } else {
            Session::flash('error_message', 'Transaction not successful! No enough points.');
            return $this->items($member->id);
        }

        return $this->items($member->id);
    }

}
