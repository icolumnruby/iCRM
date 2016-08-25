<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Branch;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Session;
use Auth;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
$user = \App\Models\User::find(1);

dd($user->getRoles());


        $branch = Branch::with('brand')
            ->where([
                    ['branch.deleted_at', NULL]
                ])
            ->paginate(20);

        return view('branch.index', compact('branch'));
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
        $branch = Branch::leftJoin('users AS a1', 'branch.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'branch.last_updated_by', '=', 'a2.id')
                ->where([
                    ['branch.id', $id],
                    ['branch.deleted_at', NULL]
                ])
                ->first(['branch.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        return view('branch.show', compact('branch'));
    }

    /**
     * Creates a new product
     *
     * @return Response
     */
    public function create()
    {
        $brands = Brand::all();

        return view('branch.create', compact('brands'));
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
            'name' => 'required',
            'brandId' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new contact
            $branch = new Branch;
            $branch->name = $request->get('name');
            $branch->address = $request->get('address');
            $branch->brand_id = $request->get('brandId');
            $branch->is_activated = $request->get('isActivated');
            $branch->created_by = $logged_in->id;
            $branch->last_updated_by = $logged_in->id;

            // save new contact
            $branch->save();

            Session::flash('flash_message', 'Branch successfully added!');

            return redirect()->route('branch.index');
        }
    }

    public function edit($id) {
        $branch = Branch::leftJoin('users AS a1', 'branch.created_by', '=', 'a1.id')
                ->leftJoin('users AS a2', 'branch.last_updated_by', '=', 'a2.id')
                ->where([
                    ['branch.id', $id],
                    ['branch.deleted_at', NULL],
                    ['a1.is_active', 'Y']
                ])
                ->first(['branch.*', 'a1.name AS created_by', 'a2.name AS updated_by']);

        $brands = Brand::all();

        return view('branch.edit', compact('branch', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     */
    public function update(Request $request, $id) {
        // update existing branch
        $branch = Branch::find($id);

        $v = $this->validate($request, [
            'name' => 'required',
            'brandId' => 'required'
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $branch->name = $request->get('name');
            $branch->address = $request->get('address');
            $branch->brand_id = $request->get('brandId');
            $branch->is_activated = $request->get('isActivated') != 'Y' ? 'N' : 'Y';
            $branch->last_updated_by = $logged_in->id;

            // save new meta
            $branch->save();

            Session::flash('flash_message', "Branch with ID $id successfully updated!");

            return redirect()->route('branch.index');
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
        $branch = Branch::findOrFail($id);

        //update last_updated_by before deleting
        $branch->last_updated_by = $logged_in->id;
        $branch->save();

        $branch->delete();

        Session::flash('flash_message', "Branch with ID $id successfully deleted!");

        return redirect()->route('branch.index');
    }
}
