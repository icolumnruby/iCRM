<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Company;
use App\Models\CompanyPassslot;
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
    $loggedIn = Auth::user();

    return view('setup.set-branches', compact('loggedIn'));
  }

  public function setManagers(){
    $loggedIn = Auth::user();

    return view('setup.set-managers', compact('loggedIn'));
  }

  public function setProductCategories(){
    $loggedIn = Auth::user();

    return view('setup.set-product-categories', compact('loggedIn'));
  }
}
