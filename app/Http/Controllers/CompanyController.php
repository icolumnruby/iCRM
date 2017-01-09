<?php

namespace App\Http\Controllers;
use App\Classes\PassSlotClass;
use App\Classes\PassSlotApiException;
use App\Models\Company;
use Illuminate\Http\Request;
use Session;
use Auth;

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
        $brand = Company::leftJoin('users AS a1', 'company.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'company.last_updated_by', '=', 'a2.id')
                ->where([
                    ['company.id', $id],
                ])
                ->first(['company.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('company.show', compact('brand'));
    }

    /**
     * Creates a new company
     *
     * @return Response
     */
    public function create()
    {
        return view('company.create');
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
            $brand->passslot_template_id = $request->get('templateId');

            $brand->is_active = $request->get('isActivated');
            $brand->created_by = $logged_in->id;
            $brand->last_updated_by = $logged_in->id;

            // save new brand
            $brand->save();

            Session::flash('flash_message', 'Company successfully added!');

            $brands = Company::paginate(20);

            return view('company.index', compact('brands'));
        }
    }

    public function edit($id) {
        $brand = Company::leftJoin('users AS a1', 'company.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'company.last_updated_by', '=', 'a2.id')
                ->where([
                    ['company.id', $id],
                    ['company.deleted_at', NULL],
                    ['company.is_active', 'Y']
                ])
                ->first(['company.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('company.edit', compact('brand'));
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

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $appKey = env('PASSSLOT_KEY');

            try {
                $engine = PassSlotClass::start($appKey);
                $data = array("name"=> $request->get('name'),
                    "passType"=> "pass.slot.storecard",
                    "description"=> array(
                        "logoText"=> $request->get('logoText'),
                        "foregroundColor"=> $request->get('foregroundColor'),
                        "backgroundColor"=> $request->get('backgroundColor'),
                        "storeCard" => array(
                            "primaryFields"=> array(
                                array(
                                    "key"=> "points",
                                    "label"=> "points",
                                    "value"=> "$(memberPoints)"
                                )
                            ),
                            "auxiliaryFields"=> array(
                                array(
                                    "key"=> "companyId",
                                    "label"=> "Company ID",
                                    "value"=> $request->get('companyId')
                                )
                            )
                        )
                    )
                );

                $response = $engine->createTemplate('POST', $data);
                $responseArr = json_decode($response);

                if (isset($responseArr['id'])) {
                    $company = Company::findOrFail($request->get('companyId'));

                    $company->passslot_template_id = $responseArr['id'];
                    $company->last_updated_by = $loggedIn->id;
                    $company->save();

                    Session::flash('flash_message', "PassSlot Template was created successfully.");
                } else {
                    Session::flash('error_message', "Error saving template. Please try again!");
                }
            } catch (PassSlotApiException $e) {
                Session::flash('error_message', "Error saving template. Please try again!");
                return redirect()->back()->withInput($request->all())->withErrors([$e->getMessage()]);
            }

            return $this->createPassSlotTemplate();
        }

    }
}
