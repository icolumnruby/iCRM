<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Company;
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

  public function chooseProgram(){
    return view('setup.program');
  }

  public function setTemplate(){
    $loggedIn = Auth::user();

    return view('setup.pass-template', compact('loggedIn'));
  }

  public function setTemplateImages(){
    $loggedIn = Auth::user();

    return view('setup.pass-template-images', compact('loggedIn'));
  }
}
