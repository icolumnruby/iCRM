<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Country;
use App\Models\Nationality;
use App\Models\MemberPoints;
use App\Models\MemberPointsTxn;
use App\Models\LoyaltyConfig;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;

class MemberController extends Controller {

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $logged_in = Auth::user();
        $members = Member::where([
                    ['members.company_id', $logged_in->company_id],
                ])
                ->paginate(20);

        return view('member.index', compact('members'));
    }

    /**
     * Search for member
     *
     * @param Response
     */
    public function search(Request $request)
    {
        $logged_in = Auth::user();
        $keyword = $request->get('search');

        $members = Member::whereRaw(
                "members.firstname like '%$keyword%' OR members.lastname like '%$keyword%'"
                . "AND members.company_id = $logged_in->company_id"
                )
                ->orderBy('members.id')
                ->paginate(20);

        return view('member.index', compact('members'));
    }

    /**
     * Displays the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $logged_in = Auth::user();
        $member = Member::leftJoin('users AS a1', 'members.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'members.last_updated_by', '=', 'a2.id')
                ->where([
                    ['members.id', $id],
                ])
                ->first(['members.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        //get the member's loyalty points
        $totalPoints = MemberPoints::_getPoints($member->id);

        //TODO get points spent from rewards and deduct it

        return view('member.show', compact('member', 'totalPoints'));
    }

    /**
     * Creates a new member with meta data/custom fields
     *
     * @return Response
     */
    public function create()
    {
        $logged_in = Auth::user();
        $countries = Country::all();
        $nationalities = Nationality::all();

        return view('member.create', compact('countries', 'nationalities'));
    }

    /**
     * Create a new member.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $logged_in = Auth::user();
        //validate required fields
        $v = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required',
            'memberTypeId' => 'required',
            'nric' => 'required|is_valid_nric|unique:members,nric,NULL,id,deleted_at,NULL' // check if unique
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new member
            $member = new Member;
            $member->salutation = $request->get('salutation');
            $member->firstname = $request->get('firstname');
            $member->middlename = $request->get('middlename');
            $member->lastname = $request->get('lastname');
            $member->gender = $request->get('gender');
            $member->email = $request->get('email');
            $member->nric = $request->get('nric');
            $member->birthdate = $request->get('birthdate');
            $member->mobile_country_code = $request->get('mobileCountryCode');
            $member->mobile = $request->get('mobile');
            $member->state = $request->get('state');
            $member->city = $request->get('city');
            $member->country_id = $request->get('countryId');
            $member->postal_code = $request->get('postalCode');
            $member->nationality_id = $request->get('nationalityId');
            $member->company_id = $logged_in->company_id;
            $member->member_type_id = $request->get('memberTypeId');
            $member->email_subscribe = ($request->get('emailSubscribe') == 'Y') ? 'Y' : 'N';
            $member->sms_subscribe = ($request->get('smsSubscribe') == 'Y') ? 'Y' : 'N';

            $member->created_by = $logged_in->id;
            $member->last_updated_by = $logged_in->id;

            // save new member
            $member->save();

            //get the member_id and save other data to member_detail table
            $member_id = $member->id;

            //check if there are equivalent points conversion for member with action = signup
            $loyaltyConfig = LoyaltyConfig::where([
                    ['company_id', $member->company_id],
                    ['start_date', '<=', date('Y-m-d H:i:s')],
                    ['is_active', 'Y'],
                    ['member_type_id', $member->member_type_id],
                    ['action_id', 2]  //signup
                ])
                ->where(function($query){
                    return $query
                              ->where('end_date', '>=', date('Y-m-d H:i:s'))
                              ->orWhere('end_date', date('0000-00-00 00:00:00'));
                })
                ->get();

            $pointsEarned = 0;
            // (total amount / value) * points, by member_type
            foreach ($loyaltyConfig as $config) {
                $pointsEarned += $config->points;

                //save member points
                $memberTotalPoints = MemberPoints::_getPoints($member->id);  //get the member's loyalty points
                $memberPoints = new MemberPoints;
                $memberPoints->member_id = $member_id;
                $memberPoints->points = $pointsEarned;
                $memberPoints->points_balance = $pointsEarned + $memberTotalPoints;
                $memberPoints->created_by = $logged_in->id;
                $memberPoints->last_updated_by = $logged_in->id;

                $memberPoints->save();

                //save member points transaction
                $memberPointsTxn = new MemberPointsTxn;
                $memberPointsTxn->member_id = $member_id;
                $memberPointsTxn->loyalty_config_id = $config->id;
                $memberPointsTxn->member_points_id = $memberPoints->id;
                $memberPointsTxn->points = $pointsEarned;
                $memberPointsTxn->expiry = $config->expiry;
                $memberPointsTxn->created_by = $logged_in->id;
                $memberPointsTxn->last_updated_by = $logged_in->id;

                $memberPointsTxn->save();
            }

            Session::flash('flash_message', "Member with ID $member_id was successfully added!");

            return redirect()->route('member.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $logged_in = Auth::user();
        $member = Member::leftJoin('users AS a1', 'members.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'members.last_updated_by', '=', 'a2.id')
                ->where([
                    ['members.id', $id],
                ])
                ->first(['members.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        $countries = Country::all();
        $nationalities = Nationality::all();

        return view('member.edit', compact('member', 'countries', 'nationalities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $logged_in = Auth::user();
        // update existing user
        $member = Member::find($id);

        $v = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required',
            'memberTypeId' => 'required',
            'nric' => 'required|is_valid_nric'
        ]);

//TODO
//check the NRIC if it has changed, if it is check if unique
//checksum
        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            //update member
            $member->salutation = $request->get('salutation');
            $member->firstname = $request->get('firstname');
            $member->middlename = $request->get('middlename');
            $member->lastname = $request->get('lastname');
            $member->gender = $request->get('gender');
            $member->email = $request->get('email');
            $member->nric = $request->get('nric');
            $member->birthdate = $request->get('birthdate');
            $member->mobile_country_code = $request->get('mobileCountryCode');
            $member->mobile = $request->get('mobile');
            $member->state = $request->get('state');
            $member->city = $request->get('city');
            $member->country_id = $request->get('countryId');
            $member->postal_code = $request->get('postalCode');
            $member->nationality_id = $request->get('nationalityId');
            $member->member_type_id = $request->get('memberTypeId');
            $member->email_subscribe = ($request->get('emailSubscribe') == 'Y') ? 'Y' : 'N';
            $member->sms_subscribe = ($request->get('smsSubscribe') == 'Y') ? 'Y' : 'N';
            $member->last_updated_by = $logged_in->id;

            // save the member
            $member->save();

            Session::flash('flash_message', 'Member with ID '. $member->id .' was successfully updated!');

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
        $loggedin = Auth::user();
        $member = Member::findOrFail($id);

        //update last_updated_by before deleting
        $member->last_updated_by = $loggedin->id;
        $member->save();

        $member->delete();

        Session::flash('flash_message', 'Member successfully deleted!');

        return redirect()->route('member.index');
    }

    public function import()
    {
        return view('member.import');
    }

    public function export()
    {
        $loggedin = Auth::user();

        return view('member.export', compact('loggedin'));
    }

    public function exportMember($companyId)
    {
        if ($companyId) {
            $member = Member::where('company_id', $companyId)->get();

//TODO put checkboxes for optional fields
            $export = Excel::create('Member_'. date('Y-m-d H:i:s'), function($excel) use($member) {
                    $excel->sheet('Sheetname', function($sheet) use($member) {
                        $sheet->fromArray($member->toArray());
                    });
                })->export('xls');
        }

        return view('member.export');
    }


}
