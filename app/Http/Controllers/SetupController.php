<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Branch;
use App\Models\Company;
use App\Models\CompanyPassslot;
use App\Models\ProductCategory;
use App\Models\User;
use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;
use Auth;

class SetupController extends Controller
{
  public function index(){
    $logged_in = Auth::user();

    $company = Company::where([
                ['company.id', $logged_in->company_id],
            ])
            ->get()
            ->count();

    return view('setup.index', compact('company'));
  }

  public function setProgram(){
    return view('setup.program');
  }

  public function setTemplate(){
    $loggedIn = Auth::user();

    return view('setup.pass-template', compact('loggedIn'));
  }

  public function setTemplateImages($id){
    $loggedIn = Auth::user();
    $passTemplate = CompanyPassslot::where([
        ['company_passslot.passslot_id', $id],
    ])
    ->first();

    return view('setup.pass-template-images', compact('loggedIn', 'passTemplate'));
  }

  public function setBranches(){
    $user = Auth::user();

    $branches = Branch::with('company')
        ->where([
                ['branch.deleted_at', NULL],
                ['branch.company_id', $user->company_id]
            ])
        ->get();

    return view('setup.set-branches', compact('user', 'branches'));
  }

  public function setManagers(){
    $user = Auth::user();
    $type = 2;
    $branches = Branch::with('company')
        ->where([
                ['branch.deleted_at', NULL],
                ['branch.company_id', $user->company_id]
            ])
        ->get();

    $managers = User::where([
                ['company_id', $user->company_id],
                ['branch_id', '!=', 0],
            ])
            ->get();

    return view('setup.set-managers', compact('user', 'branches', 'type', 'managers'));
  }

  public function setProductCategories(){
    $user = Auth::user();
    $categories = ProductCategory::where([
//                    ['products.branch_id', $logged_in->company_id],
            ])
            ->get();

    return view('setup.set-product-categories', compact('user', 'categories'));
  }

  public function confirmSetup(){
    $user = Auth::user();
    
    $passTemplate = CompanyPassslot::where([
                ['company_passslot.company_id', $user->company_id],
                ['company_passslot.pass_type', 'pass.slot.storecard'],
            ])
            ->first();

    $branches = Branch::with('company')
        ->where([
                ['branch.deleted_at', NULL],
                ['branch.company_id', $user->company_id]
            ])
        ->get();

    $managers = User::where([
                ['company_id', $user->company_id],
                ['branch_id', '!=', 0],
            ])
            ->get();

    $categories = ProductCategory::where([
//                    ['products.branch_id', $logged_in->company_id],
            ])
            ->get();

    return view('setup.setup-confirm', compact('user', 'passTemplate', 'branches', 'managers', 'categories'));
  }
}
