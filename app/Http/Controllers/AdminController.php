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
use Validator;

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

        $company['setup'] = Company::where([
                    ['company.id', $logged_in->company_id],
                    ['company.has_setup', 'N'],
                ])
                ->get()
                ->count();

        // $company = Company::where([
        //             ['company.id', $logged_in->company_id],
        //         ])
        //         ->get()
        //         ->count();

        if ($company['setup']) {
          // store has setup condition on session
          session(['has_setup' => false]);
          return redirect('setup');
        }
        // remove has setup condition on session
        session(['has_setup' => true]);

        return view('admin.dashboard', compact('members'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'mobile' => 'required',
//                'g-recaptcha-response'  => 'required'
            ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerMechant(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput($request->all());
        }
        if($this->captchaCheck() == false)
        {
//            return redirect()->back()
//                ->withErrors(['Wrong Captcha'])
//                ->withInput();
        }

        $this->saveMerchant($request->all());
//        Auth::guard($this->getGuard())->login($this->create($request->all()));

//        return redirect($this->redirectPath());
        Session::flash('flash_message', "Application has been submitted and is subject for approval!");
        return redirect()->back()
                ->with('registered', true);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function saveMerchant(array $data)
    {
        $company = new Company;

        $company->mobile = $data['mobile'];
        $company->country_id = $data['country_id'];

        $company->save();

        //save the new user
        $user = new User;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->is_active = 'N';
        $user->company_id = $company->id;
        $user->type = 1;                    //merchant/company admin

        $user->save();

        $this->notifyMerchant($user);   //send email to merchant
        $this->notifyAdmin(merge($user, $company)); //send email to admin

        return true;
    }

    /**
     * Send an email to Merchant that their registration is received and needs admin approval
     */
    public function notifyMerchant($user)
    {
        Mail::send('admin.emails.notify-merchant', ['user' => $user], function ($m) use ($user) {
            $m->from('info@icolumn.com', 'iColumn CRM');

            $m->to($user->email, $user->name)->subject('Application received!');
        });
    }

    /**
     * Send an email notifiation to Admin for new merchant sign up
     */
    public function notifyAdmin($user)
    {
        Mail::send('admin.emails.notify-admin', ['user' => $user], function ($m) use ($user) {
            $m->from($user->email, $user->name);

            $m->to('ruby@icolumn.com', 'Admin')->subject('New Merchant Application!');
        });
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

    public function createDB()
    {
        $this->middleware('web');

        $dbhost = env('DB_HOST');
        $dbport = env('DB_PORT');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');
        $link = mysqli_connect($dbhost, $dbuser, $dbpass);

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        echo 'Connected successfully';

        $sql = 'CREATE Database test_db';
        $retval = mysqli_query( $link, $sql );

        if(!$retval) {
           die('Could not create database: ' . mysql_error());
        }

        echo "Database test_db created successfully\n";
        mysqli_close($link);
    }

    public function viewMerchant()
    {
        return view('admin.merchant');
    }
}
