<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meta;
use App\Models\CompanyMeta;
use Auth;
use Session;

class MetaController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {
        $logged_in = Auth::user();

        //retrieve all the activated custom fields from client
        $companyMeta = CompanyMeta::select('meta.*', 'users.name AS account_name')
                ->leftjoin('meta', 'company_meta.meta_id', '=', 'meta.id')
                ->leftJoin('users', 'meta.created_by', '=', 'users.id')
                ->where([
                    ['company_meta.company_id', $logged_in->company_id],
                    ['meta.is_activated', 'Y'],
                    ['meta.deleted_at', NULL]
                ])
                ->paginate(20);

        return view('meta.index', compact('companyMeta'));
    }

    public function create() {
        return view('meta.create');
    }

    public function edit($id) {
        $meta = Meta::leftJoin('users AS a1', 'meta.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'meta.last_updated_by', '=', 'a2.id')
                ->where([
                    ['meta.id', $id],
                    ['meta.is_activated', 'Y'],
                    ['meta.deleted_at', NULL],
                    ['a1.is_active', 'Y']
                ])
                ->first(['meta.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('meta.edit', compact('meta'));
    }

    /**
     * Create a new meta.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

         //validate required fields
        $v = $this->validate($request, [
            'name' => 'required',
            'type' => 'required'
        ]);
        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();
            $options = '';
            if (!empty($request->get('options'))) { //make the options "|" separated
                $options = preg_replace("/\r\n/",'|',trim($request->get('options')));
            }
            // create the data for new meta
            $meta = new Meta;
            $meta->name = $request->get('name');
            $meta->type = $request->get('type');
            $meta->rank = $request->get('rank');
            $meta->max_length = $request->get('maxLength');
            $meta->multiselect = $request->get('multiselect');
            $meta->options = $options;
            $meta->date_format = $request->get('date-format');
            $meta->is_mandatory = $request->get('mandatory');
            $meta->mandatory_msg = $request->get('mandatoryMsg');
            $meta->description = $request->get('description');
            $meta->created_by = $logged_in->id;

            // save new meta
            $meta->save();

            //get the meta_id and save other data to contact_detail table
            $meta_id = $meta->id;

            $companyMeta = new CompanyMeta();
            $companyMeta->company_id = $logged_in->company_id;
            $companyMeta->meta_id = $meta_id;

            // save new company_meta
            $companyMeta->save();

            Session::flash('flash_message', 'Custom Field successfully added!');

            return redirect()->route('meta.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing user
        $meta = Meta::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
            'type' => 'required'
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $options = '';
            if (!empty($request->get('options'))) { //make the options comma-separated
                $options = preg_replace("/\r\n|\r|\n/",'|',$request->get('options'));
            }

            $meta->name = $request->get('name');
            $meta->type = $request->get('type');
            $meta->rank = $request->get('rank');
            $meta->max_length = $request->get('maxLength');
            $meta->multiselect = $request->get('multiselect');
            $meta->options = $options;
            $meta->date_format = $request->get('date-format');
            $meta->is_mandatory = $request->get('mandatory');
            $meta->mandatory_msg = $request->get('mandatoryMsg');
            $meta->description = $request->get('description');
            $meta->last_updated_by = $logged_in->id;

            // save new meta
            $meta->save();

            Session::flash('flash_message', 'Custom Field successfully updated!');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id) {
        $logged_in = Auth::user();
        $meta = Meta::findOrFail($id);

        //update last_updated_by before deleting
        $meta->last_updated_by = $logged_in->id;
        $meta->save();

        $meta->delete();

        Session::flash('flash_message', 'Custom Field successfully deleted!');

        return redirect()->route('meta.index');
    }
}
