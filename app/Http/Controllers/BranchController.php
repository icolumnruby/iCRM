<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Branch;
use App\Models\User;
use App\Models\RoleUser;
use Session;
use Auth;
use Validator;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $user = Auth::user();

        $branches = Branch::with('company')
            ->where([
                    ['branch.deleted_at', NULL],
                    ['branch.company_id', $user->company_id]
                ])
            ->paginate(20);

        return view('branch.index', compact('branches'));
    }

    /**
     * Displays the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
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
        $user = Auth::user();

        return view('branch.create', compact('user'));
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
            'company_id' => 'required',
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            // create the data for new member
            $branch = new Branch;
            $branch->name = $request->get('name');
            $branch->address = $request->get('address');
            $branch->company_id = $request->get('company_id');
            $branch->is_active = $request->get('isActivated');
            $branch->created_by = $logged_in->id;
            $branch->last_updated_by = $logged_in->id;

            // save new branch
            $branch->save();

            Session::flash('flash_message', 'Branch successfully added!');

            $branches = Branch::with('company')
            ->where([
                    ['branch.deleted_at', NULL]
                ])
            ->paginate(20);

            return redirect()->route('branch.index', compact('branches'));
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

        $brands = Company::all();

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
        ]);

        if ($v && $v->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($v->errors());
        } else {
            $logged_in = Auth::user();

            $branch->name = $request->get('name');
            $branch->address = $request->get('address');
            $branch->is_active = $request->get('isActivated') != 'Y' ? 'N' : 'Y';
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

    /**
     * Show the add branch admin page. Where admin is manager or staff
     */
    public function addManager()
    {
        $user = Auth::user();
        $type = 2;
        $branches = Branch::with('company')
            ->where([
                    ['branch.deleted_at', NULL],
                    ['branch.company_id', $user->company_id]
                ])
            ->get();

        return view('branch.create-user', compact('user', 'branches', 'type'));
    }

    /**
     * Show the add branch admin page. Where admin is manager or staff
     */
    public function addStaff()
    {
        $user = Auth::user();
        $type = 3;
        $branches = Branch::with('company')
            ->where([
                    ['branch.deleted_at', NULL],
                    ['branch.company_id', $user->company_id]
                ])
            ->get();


        return view('branch.create-user', compact('user', 'branches', 'type'));
    }

    /**
     * Creates a new branch manager|staff
     */
    public function saveUser(Request $request)
    {
//TODO check for permission
        $logged_in = Auth::user();
        $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'company_id' => 'required',
                'branch_id' => 'required',
            ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput($request->all());
        }
        //save the new user
        $user = new User;

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->company_id = $request->get('company_id');
        $user->branch_id = $request->get('branch_id');
        $user->type = $request->get('type');
        $user->is_active = $request->get('isActivated') == 'Y' ? 'Y' : 'N';

        $user->save();

        //add role to user
        if (User::$_type[$user->type] == 'manager') { //branch manager
            $userRole = new RoleUser;

            $userRole->user_id = $user->id;
            $userRole->role_id = 2;

            $userRole->save();
        } elseif (User::$_type[$user->type] == 'staff') { //branch staff
            $userRole = new RoleUser;

            $userRole->user_id = $user->id;
            $userRole->role_id = 3;

            $userRole->save();
        }

        Session::flash('flash_message', "Branch Admin with ID " . $user->id . " successfully added!");

        return $this->showUsers($logged_in->company_id);

    }


    /**
     * Displays the list of branch users.
     */
    public function showUsers($companyId)
    {
        $logged_in = Auth::user();
        $users = User::where([
                    ['company_id', $companyId],
                    ['branch_id', '!=', 0],
                ])
                ->paginate(20);

        return view('branch.show-users', compact('users'));
    }

}

