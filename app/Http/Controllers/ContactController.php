<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CompanyMeta;
use App\Models\ContactMetaValue;
use App\Models\Country;
use App\Models\Nationality;
use App\Http\Controllers\Controller;
use Session;
use Auth;

class ContactController extends Controller {

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $logged_in = Auth::user();
        $contacts = Contact::where([
                    ['contacts.company_id', $logged_in->company_id],
                ])
                ->paginate(2);

        return view('contact.index', compact('contacts'));
    }

    /**
     * Search for contact
     *
     * @param Response
     */
    public function search(Request $request)
    {
        $logged_in = Auth::user();
        $keyword = $request->get('search');

        $contacts = Contact::whereRaw(
                "contacts.firstname like '%$keyword%' OR contacts.lastname like '%$keyword%'"
                . "AND contacts.company_id = $logged_in->company_id"
                )
                ->orderBy('contacts.id')
                ->paginate(2);

        return view('contact.index', compact('contacts'));
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
        $contact = Contact::leftJoin('users AS a1', 'contacts.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'contacts.last_updated_by', '=', 'a2.id')
                ->where([
                    ['contacts.id', $id],
                ])
                ->first(['contacts.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        //retrieve all the activated custom fields from client
        $contactMeta = CompanyMeta::select('company_meta.*', 'meta.*', 'contact_meta_value.id AS cmv_id', 'contact_meta_value.value AS cmv_value')
                ->leftjoin('meta', 'company_meta.meta_id', '=', 'meta.id')
                ->leftjoin('contact_meta_value', 'contact_meta_value.meta_id', '=', 'meta.id')
                ->where([
                    ['meta.is_activated', 'Y'],
                    ['meta.deleted_at', NULL],
                    ['company_meta.company_id', $logged_in->company_id],
                    ['contact_meta_value.contact_id', $id],
                ])
                ->orderBy(\DB::raw('-meta.rank'), 'desc')
                ->get();

        return view('contact.show', compact('contact', 'contactMeta'));
    }

    /**
     * Creates a new contact with meta data/custom fields
     *
     * @return Response
     */
    public function create()
    {
        $logged_in = Auth::user();
        $countries = Country::all();
        $nationalities = Nationality::all();

        //retrieve all the activated custom fields from client
        $companyMeta = CompanyMeta::leftjoin('meta', 'company_meta.meta_id', '=', 'meta.id')
                ->select('*')
                ->where([
                    ['company_meta.company_id', $logged_in->company_id],
                    ['meta.is_activated', 'Y'],
                    ['meta.deleted_at', NULL]
                ])
                ->orderBy(\DB::raw('-meta.rank'), 'desc')
                ->get();

        return view('contact.create', compact('countries', 'nationalities', 'companyMeta'));
    }

    /**
     * Create a new contact.
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
            'nric' => 'required|is_valid_nric|unique:contacts,nric,NULL,id,deleted_at,NULL' // check if unique
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new contact
            $contact = new Contact;
            $contact->salutation = $request->get('salutation');
            $contact->firstname = $request->get('firstname');
            $contact->middlename = $request->get('middlename');
            $contact->lastname = $request->get('lastname');
            $contact->gender = $request->get('gender');
            $contact->email = $request->get('email');
            $contact->nric = $request->get('nric');
            $contact->birthdate = $request->get('birthdate');
            $contact->mobile_country_code = $request->get('mobileCountryCode');
            $contact->mobile = $request->get('mobile');
            $contact->state = $request->get('state');
            $contact->city = $request->get('city');
            $contact->country_id = $request->get('countryId');
            $contact->postal_code = $request->get('postalCode');
            $contact->nationality_id = $request->get('nationalityId');
            $contact->company_id = $logged_in->company_id;
//            $contact->is_member = $request->get('isMember');
            $contact->member_type = $request->get('memberType');
            $contact->created_by = $logged_in->id;

            // save new contact
            $contact->save();

            //get the contact_id and save other data to contact_detail table
            $contact_id = $contact->id;

            //save client_contact_meta_value
            if (count($request->get('meta'))) {
                foreach ($request->get('meta') as $meta_id => $val) {
                    $contactMetaValue = new ContactMetaValue;
                    if (is_array($val)) {
                        $contactMetaValue->value = implode('|', $val);
                    } else {
                        $contactMetaValue->value = $val;
                    }
                    $contactMetaValue->meta_id = $meta_id;
                    $contactMetaValue->contact_id = $contact_id;

                    $contactMetaValue->save();
                }
            }

            Session::flash('flash_message', 'Contact successfully added!');

            return redirect()->route('contact.index');
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
        $contact = Contact::leftJoin('users AS a1', 'contacts.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'contacts.last_updated_by', '=', 'a2.id')
                ->where([
                    ['contacts.id', $id],
                ])
                ->first(['contacts.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        $countries = Country::all();
        $nationalities = Nationality::all();

        //retrieve all the activated custom fields from client
        $contactMeta = CompanyMeta::select('company_meta.*', 'meta.*', 'contact_meta_value.id AS cmv_id', 'contact_meta_value.value AS cmv_value')
                ->leftjoin('meta', 'company_meta.meta_id', '=', 'meta.id')
                ->leftjoin('contact_meta_value', 'contact_meta_value.meta_id', '=', 'meta.id')
                ->where([
                    ['meta.is_activated', 'Y'],
                    ['meta.deleted_at', NULL],
                    ['company_meta.company_id', $logged_in->company_id],
                    ['contact_meta_value.contact_id', $id],
                ])
                ->orderBy(\DB::raw('-meta.rank'), 'desc')
                ->get();

        return view('contact.edit', compact('contact', 'countries', 'nationalities', 'contactMeta'));
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
        $contact = Contact::find($id);

        $v = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'birthdate' => 'required',
            'nric' => 'required|is_valid_nric'
        ]);

//TODO
//check the NRIC if it has changed, if it is check if unique
//checksum
        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            //update contact
            $contact->salutation = $request->get('salutation');
            $contact->firstname = $request->get('firstname');
            $contact->middlename = $request->get('middlename');
            $contact->lastname = $request->get('lastname');
            $contact->gender = $request->get('gender');
            $contact->email = $request->get('email');
            $contact->nric = $request->get('nric');
            $contact->birthdate = $request->get('birthdate');
            $contact->mobile_country_code = $request->get('mobileCountryCode');
            $contact->mobile = $request->get('mobile');
            $contact->state = $request->get('state');
            $contact->city = $request->get('city');
            $contact->country_id = $request->get('countryId');
            $contact->postal_code = $request->get('postalCode');
            $contact->nationality_id = $request->get('nationalityId');
//            $contact->is_member = $request->get('isMember');
            $contact->member_type = $request->get('memberType');
            $contact->last_updated_by = $logged_in->id;

            // save the contact
            $contact->save();

            //save contact_meta_value
            if (count($request->get('meta'))) {
                foreach ($request->get('meta') as $meta_id => $val) {
                    $contactMetaValue = ContactMetaValue::where([
                            ['meta_id', $meta_id],
                            ['contact_id', $id]
                        ])->first();
                    if (!$contactMetaValue) { //if the contact_meta_value doesn't exist yet
                        $contactMetaValue = new ContactMetaValue;
                        $contactMetaValue->meta_id = $meta_id;
                        $contactMetaValue->contact_id = $id;
                    }

                    if (is_array($val)) {
                        $contactMetaValue->value = implode('|', $val);
                    } else {
                        $contactMetaValue->value = $val;
                    }

                    //update contact_meta_value
                    $contactMetaValue->save();
                }
            }

            Session::flash('flash_message', 'Contact successfully updated!');

            return redirect()->back();
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
        $contact = Contact::findOrFail($id);

        //update last_updated_by before deleting
        $contact->last_updated_by = $logged_in->id;
        $contact->save();

        $contact->delete();

        Session::flash('flash_message', 'Contact successfully deleted!');

        return redirect()->route('contact.index');
    }

    public function import()
    {
        return view('contact.import');
    }

    public function export()
    {
        return view('contact.export');
    }

}
