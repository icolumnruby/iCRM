<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\User;
use App\Models\Company;
use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    protected $guard = 'admin';

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
                'brand' => 'required',
                'fullname' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'mobile' => 'required',
                'g-recaptcha-response'  => 'required'
            ]);
    }

    /**
     * Create a new merchant user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $company = new Company;

        $company->brand_name = $data['brand'];
        $company->company = $data['company'];
        $company->fullname = $data['fullname'];
        $company->email = $data['email'];
        $company->mobile = $data['mobile'];
        $company->address = $data['address'];
        $company->country_id = $data['country_id'];
        $company->comments = $data['comments'];
        $company->is_active = 'Y';

        $company->save();

        //save the new user
        $user = new User;

        $user->name = $data['fullname'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['email']);
        $user->is_active = 'N';
        $user->company_id = $company->id;
        $user->branch_id = 1;   //set 1 as the default branch
        $user->type = 1;                    //merchant/company admin

        $user->save();

        // assign merchant a branh manager role
        $user->assignRole('manager');

        $this->notifyMerchant($user);   //send email to merchant
        $this->notifyAdmin($company); //send email to admin

        return true;
    }

    public function authenticate(array $data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'is_active' => 'Y'])) {
            // Authentication passed...
            return redirect()->intended('/admin');
        }
    }

    public function showLoginForm()
    {
        if (view()->exists('admin.authenticate')) {
            return view('admin.authenticate');
        }

        return view('admin.login');
    }

    public function showRegistrationForm()
    {
        $countries = \App\Models\Country::all();
        $attributes = [
            'data-theme' => 'light',
            'data-type' =>  'audio',
        ];

        return view('admin.register', compact('countries', 'attributes'));
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
    public function notifyAdmin($data)
    {
        Mail::send('admin.emails.notify-admin', ['user' => $data], function ($m) use ($data) {
            $m->from($data->email, $data->fullname);

            $m->to('ruby@icolumn.com', 'Admin')->subject('New Merchant Application!');
        });
    }
}
