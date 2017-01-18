<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Company;
use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;
use Auth;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(){
//$admin = \App\Models\User::first(); // administrator
//var_dump($admin->can('create.product.category'));
//var_dump($admin->is('administrator'));
//var_dump($admin->getPermissions());exit;
        $logged_in = Auth::user();
        $members['total'] = Member::where([
                    ['members.company_id', $logged_in->company_id],
                ])
                ->get()
                ->count();

        $members['transactions'] = Transaction::where([
                    ['updated_at', '>=', date('Y-m-d', strtotime('-7 days'))],
                ])
                ->get()
                ->count();

        $company['has_setup'] = Company::where([
                    ['company.id', $logged_in->company_id],
                    ['company.has_setup', 'N'],
                ])
                ->get()
                ->count();

        $company = Company::where([
                    ['company.id', $logged_in->company_id],
                ])
                ->get()
                ->count();

        if ($company['has_setup']) {
          return redirect('setup');
        }

        return view('admin.dashboard', compact('members', 'company'));
    }

    public function createPermission()
    {
        $permission = new Permission();
        $permission->create([
            'name'        => 'admin',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage admin'
        ]);
        $permission->create([
            'name'        => 'branch',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage branch'
        ]);
        $permission->create([
            'name'        => 'member',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage members'
        ]);
        $permission->create([
            'name'        => 'product.category',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage product categories'
        ]);
        $permission->create([
            'name'        => 'transaction',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage transactions'
        ]);

//        var_dump($permPost->getKey());
//        var_dump($user->getRoles());
//        dd($user->getPermissions());
    }

    public function createRole()
    {
        $role = new Role();
        $role->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'manage administration privileges'
        ]);

        $role->create([
            'name' => 'Branch Manager',
            'slug' => 'manager',
            'description' => 'manage manager privileges'
        ]);

        $role->create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'manage staff privileges'
        ]);
    }

    public function assignPermToRole()
    {
        $roleAdmin = Role::first(); // administrator

        $roleAdmin->assignPermission(1);  //admin module
        $roleAdmin->assignPermission(2);  //branch module
        $roleAdmin->assignPermission(3);  //Member module
        $roleAdmin->assignPermission(4);  //product category module
        $roleAdmin->assignPermission(5);  //transaction module

        $roleAdmin = Role::find(2); // branch manager

        $roleAdmin->assignPermission(2);  //branch module
        $roleAdmin->assignPermission(3);  //Member module
        $roleAdmin->assignPermission(4);  //product category module
        $roleAdmin->assignPermission(5);  //transaction module

        $roleAdmin = Role::find(3); // staff

        $roleAdmin->assignPermission(3);  //Member module
        $roleAdmin->assignPermission(4);  //product category module
        $roleAdmin->assignPermission(5);  //transaction module

    }

    public function assignUserRole()
    {
        $user = \App\Models\User::find(1);  //admini
        // by object
        $user->assignRole('administrator');
    }
}
