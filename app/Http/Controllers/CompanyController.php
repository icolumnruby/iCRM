<?php

namespace App\Http\Controllers;
use App\Classes\PassSlotClass;
use App\Classes\PassSlotApiException;
use App\Models\Company;
use App\Models\CompanyPassslot;
use App\Models\Country;
use Illuminate\Http\Request;
use Session;
use Auth;
use Input;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $brands = Company::paginate(20);

        return view('company.index', compact('brands'));
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
        $company = Company::find($id);

        if ($company) {
            return $this->edit($id);
        }

        return $this->create();
    }

    /**
     * Creates a new company
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('company.create', compact('countries'));
    }

    /**
     * Create a new brand.
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
            'templateId' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new company
            $brand = new Company;
            $brand->name = $request->get('name');
            $brand->description = $request->get('description');
            $brand->address = $request->get('address');
            $brand->city = $request->get('city');
            $brand->state = $request->get('state');
            $brand->country_id = $request->get('countryId');
            $brand->postal_code = $request->get('postalCode');
            $brand->passslot_template_id = $request->get('templateId');

            $brand->is_active = $request->get('isActivated');
            $brand->created_by = $logged_in->id;
            $brand->last_updated_by = $logged_in->id;

            // save new company
            $brand->save();

            Session::flash('flash_message', 'Company successfully added!');

            $brands = Company::paginate(20);

            return view('company.index', compact('brands'));
        }
    }

    public function edit($id) {
        $countries = Country::all();
        $brand = Company::leftJoin('users AS a1', 'company.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'company.last_updated_by', '=', 'a2.id')
                ->where([
                    ['company.id', $id],
                    ['company.deleted_at', NULL],
                    ['company.is_active', 'Y']
                ])
                ->first(['company.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('company.edit', compact('brand', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing branch
        $brand = Company::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $brand->name = $request->get('name');
            $brand->description = $request->get('description');
            $brand->is_active = $request->get('isActivated') != 'Y' ? 'N' : 'Y';
            $brand->last_updated_by = $logged_in->id;

            // save new meta
            $brand->save();

            Session::flash('flash_message', "Company with ID $id successfully updated!");

            return redirect()->route('company.index');
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
        $brand = Company::findOrFail($id);

        //update last_updated_by before deleting
        $brand->last_updated_by = $logged_in->id;
        $brand->save();

        $brand->delete();

        Session::flash('flash_message', "Brand with ID $id successfully deleted!");

        return redirect()->route('company.index');
    }

    public function createPassSlotTemplate()
    {
        $loggedIn = Auth::user();

        return view('company.passslot-template', compact('loggedIn'));
    }

    public function savePassSlotTemplate(Request $request)
    {
        $loggedIn = Auth::user();
        $v = $this->validate($request, [
            'companyId' => 'required',
            'name' => 'required',
        ]);
        $responseArr = [];

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $appKey = env('PASSSLOT_KEY');

            try {
                $engine = PassSlotClass::start($appKey);
                $data = array("name"=> $request->get('name'),
                    "passType"=> "pass.slot.storecard",
                    "description"=> array(
                        "foregroundColor"=> $request->get('foregroundColor'),
                        "backgroundColor"=> $request->get('backgroundColor'),
                        "storeCard" => array(
                            "headerFields"=> array(
                                array(
                                    "key"=> "memberType",
                                    "label"=> "Member Type",
                                    "value"=> "\${memberType}"
                                )
                            ),
                            "primaryFields"=> array(
                                array(
                                    "key"=> "points",
                                    "label"=> "Points",
                                    "value"=> "\${memberPoints}"
                                )
                            ),
                            "secondaryFields"=> array(
                                array(
                                    "key"=> "memberName",
                                    "label"=> "Member Name",
                                    "value"=> "\${firstName} \${lastName}"
                                )
                            ),
                            "backFields"=> array(
                                array(
                                    "key"=> "validAt",
                                    "label"=> "Valid At",
                                    "value"=> $request->get('name')
                                )
                            )
                        )
                    )
                );
                $response = $engine->createTemplate('POST', $data);
                $responseArr = json_decode($response, true);

                if (isset($responseArr['id'])) {

                    $passTemplate = new CompanyPassslot;
                    $passTemplate->company_id = $request->get('companyId');
                    $passTemplate->passslot_id = $responseArr['id'];
                    $passTemplate->name = $responseArr['name'];
                    $passTemplate->pass_type = $responseArr['passType'];
                    $passTemplate->created_by = $loggedIn->id;
                    $passTemplate->last_updated_by = $loggedIn->id;
                    $passTemplate->foreground_colour = $request->get('foregroundColor');
                    $passTemplate->background_colour = $request->get('backgroundColor');

                    $passTemplate->save();

                    Session::flash('flash_message', "PassSlot Template was created successfully.");

                } else {
                    Session::flash('error_message', "Error saving template. Please try again!");
                }
            } catch (PassSlotApiException $e) {
                Session::flash('error_message', "Error saving template. Please try again!");
                return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
            }

            return redirect('/setup/pass-template/'. $responseArr['id']);
        }

    }

    public function savePassSlotImages(Request $request)
    {
        $loggedIn = Auth::user();
        $v = $this->validate($request, [
            'passTemplateId' => 'required',
            'imageType' => 'required',
        ]);
        $responseArr = [];

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
          $appKey = env('PASSSLOT_KEY');
          $passTemplateId = $request->get('passTemplateId');

          try {
              $engine = PassSlotClass::start($appKey);
              $templateId = $passTemplateId;
              $imageType = $request->get('imageType');
              $imageResolution = 'high';
              $image = $request->file('image');

              $response = $engine->saveTemplateImage($templateId, $imageType, $imageResolution, $image);
              $responseArr = json_decode($response, true);


              if (isset($responseArr['urls'])) {
                  $passTemplate = CompanyPassslot::find($request->get('passTemplateId'));
                  if ($responseArr['type'] == 'logo') {
                    $passTemplate->logo_url = $responseArr['urls']['high'];
                  } else {
                    $passTemplate->strip_url = $responseArr['urls']['high'];
                  }
                  $passTemplate->save();

                  Session::flash('flash_message', "Pass template images uploaded successfully.");

              } else {
                  Session::flash('error_message', "Error saving template. Please try again!");
              }
          } catch (PassSlotApiException $e) {
              Session::flash('error_message', "Error saving template. Please try again!");
              return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
          }

          // return redirect()->back()->withInput($request->all())->withErrors(['msg', $request]);
          Session::flash('flash_message', "Pass template images uploaded successfully.");

        }
    }

    public function completeSetup(Request $request)
    {
      $loggedIn = Auth::user();

      $brand = Company::find($loggedIn->company_id);

      $brand->has_setup = $request->get('has_setup');
      $brand->save();

      session(['has_setup' => true]);

      return redirect('/admin');
    }
}
