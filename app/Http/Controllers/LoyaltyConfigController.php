<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Branch;
use App\Models\LoyaltyConfig;
use App\Models\RoleUser;
use Session;
use Auth;
use Validator;

class LoyaltyConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $user = Auth::user();

        $loyalty = LoyaltyConfig::where([
                    ['loyalty_config.deleted_at', NULL],
                    ['loyalty_config.company_id', $user->company_id]
                ])
            ->paginate(20);

        return view('loyalty.index', compact('loyalty'));
    }

    /**
     * Displays the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $loyalty = LoyaltyConfig::leftJoin('users AS a1', 'loyalty_config.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'loyalty_config.last_updated_by', '=', 'a2.id')
                ->where([
                    ['loyalty_config.id', $id],
                    ['loyalty_config.deleted_at', NULL]
                ])
                ->first(['loyalty_config.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('loyalty.show', compact('loyalty'));
    }

    /**
     * Creates a new product
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('loyalty.create', compact('user'));
    }

    /**
     * Create a new branch.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $logged_in = Auth::user();
        //validate required fields
        $v = $this->validate($request, [
            'memberTypeId' => 'required',
            'name' => 'required',
            'actionId' => 'required',
            'points' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new loyalty config
            $loyalty = new LoyaltyConfig;
            $loyalty->member_type_id = $request->get('memberTypeId');
            $loyalty->name = $request->get('name');
            $loyalty->description = $request->get('description');
            $loyalty->action_id = $request->get('actionId');
            $loyalty->type = $request->get('actionType');
            $loyalty->value = $request->get('value');
            $loyalty->points = $request->get('points');
            $loyalty->expiry = $request->get('expiry');
            $loyalty->start_date = $request->get('startDate');
            $loyalty->end_date = $request->get('endDate');
            $loyalty->is_active = $request->get('isActivated');
            $loyalty->company_id = $logged_in->company_id;
            $loyalty->created_by = $logged_in->id;
            $loyalty->last_updated_by = $logged_in->id;

            // save new loyalty
            $loyalty->save();

            Session::flash('flash_message', 'Loyalty settings successfully added!');

            return $this->index();
        }
    }

    public function edit($id) {
        $loyalty = LoyaltyConfig::leftJoin('users AS a1', 'loyalty_config.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'loyalty_config.last_updated_by', '=', 'a2.id')
                ->where([
                    ['loyalty_config.id', $id],
                    ['loyalty_config.deleted_at', NULL],
                    ['a1.is_active', 'Y']
                ])
                ->first(['loyalty_config.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('loyalty.edit', compact('loyalty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing branch
        $loyalty = LoyaltyConfig::find($id);
        $v = $this->validate($request, [
            'name' => 'required',
            'actionId' => 'required',
            'points' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $loyalty->name = $request->get('name');
            $loyalty->description = $request->get('description');
            $loyalty->action_id = $request->get('actionId');
            $loyalty->type = $request->get('actionType');
            $loyalty->value = $request->get('value');
            $loyalty->points = $request->get('points');
            $loyalty->expiry = $request->get('expiry');;
            $loyalty->start_date = $request->get('startDate');
            $loyalty->end_date = $request->get('endDate');
            $loyalty->is_active = $request->get('isActivated');
            $loyalty->company_id = $logged_in->company_id;
            $loyalty->created_by = $logged_in->id;
            $loyalty->last_updated_by = $logged_in->id;

            // save new meta
            $loyalty->save();

            Session::flash('flash_message', "Loyalty Config with ID $id successfully updated!");

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
        $loyalty = LoyaltyConfig::findOrFail($id);

        //update last_updated_by before deleting
        $loyalty->last_updated_by = $logged_in->id;
        $loyalty->save();

        $loyalty->delete();

        Session::flash('flash_message', "Loyalty Config with ID $id successfully deleted!");

        return redirect()->route('loyalty.index');
    }
}
