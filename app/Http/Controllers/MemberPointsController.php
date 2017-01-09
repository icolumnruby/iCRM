<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberPoints;
use App\Models\MemberPointsTxn;
use App\Models\LoyaltyConfig;
use Session;
use Auth;
use Validator;

class MemberPointsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function addPoints($memberId)
    {
        $member = Member::find($memberId);
        $loyaltyConfig = LoyaltyConfig::where([
                ['company_id', $member->company_id],
                ['start_date', '<=', date('Y-m-d H:i:s')],
                ['is_active', 'Y'],
                ['member_type_id', $member->member_type_id],
                ['action_id', '!=', 1]  //not purchase
            ])
            ->where(function($q) {
                $q->where('end_date', '>=', date('Y-m-d H:i:s'))
                    ->orWhere('end_date', '0000-00-00 00:00:00')
                    ->orWhere('end_date', NULL);
            })
            ->get();

        return view('member.add-points', compact('member', 'loyaltyConfig'));
    }

    public function savePoints(Request $request)
    {
        $logged_in = Auth::user();

        //check if there are equivalent points conversion for member with type = purchase
        $member = Member::find($request->get('memberId'));
        $loyaltyConfig = LoyaltyConfig::findOrFail($request->get('loyaltyConfigId'));

        //save member points
        $memberTotalPoints = MemberPoints::_getPoints($member->id);  //get the member's loyalty points
        $memberPoints = new MemberPoints;
        $memberPoints->member_id = $member->id;
        $memberPoints->points = $loyaltyConfig->points;

        if ($loyaltyConfig->type == '+') {
            $memberPoints->points_balance = $loyaltyConfig->points + (int) $memberTotalPoints;
            $status = "Member points earned: " . $loyaltyConfig->points;
        } elseif ($loyaltyConfig->type == '-') {
            $memberPoints->points_balance = (int) $memberTotalPoints - $loyaltyConfig->points;
            $status = "Member points deducted: " .$loyaltyConfig->points;
        }
        $memberPoints->created_by = $logged_in->id;
        $memberPoints->last_updated_by = $logged_in->id;

        if ($memberPoints->points_balance >= 0) {
            $memberPoints->save();
            //save member points transaction
            $memberPointsTxn = new MemberPointsTxn;
            $memberPointsTxn->member_id = $member->id;
            $memberPointsTxn->loyalty_config_id = $loyaltyConfig->id;
            $memberPointsTxn->member_points_id = $memberPoints->id;
            $memberPointsTxn->points = $loyaltyConfig->points;
            $memberPointsTxn->expiry = $loyaltyConfig->expiry;
            $memberPointsTxn->remarks = $request->get('remarks');
            $memberPointsTxn->created_by = $logged_in->id;
            $memberPointsTxn->last_updated_by = $logged_in->id;

            $memberPointsTxn->save();
            Session::flash('flash_message', $status);
        } else {
            $status = "Transaction not successful! No enough points.";
            Session::flash('error_message', $status);
        }

        return $this->addPoints($member->id);
    }

    public function pointsLog()
    {
        $memberPoints = MemberPointsTxn::select(['member_points_txn.*', 'members.id AS memberId', 'members.firstname', 'members.lastname', 'loyalty_config.action_id', 'loyalty_config.type'])
                ->leftJoin('members', 'member_points_txn.member_id', '=', 'members.id')
                ->leftJoin('loyalty_config', 'member_points_txn.loyalty_config_id', '=', 'loyalty_config.id')
                ->orderBy('member_points_txn.updated_at', 'DESC')
                ->paginate(20);

        return view('member.points-log', compact('memberPoints'));
    }
}
