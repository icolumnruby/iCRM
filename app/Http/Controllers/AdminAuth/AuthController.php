<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\User;
use App\Models\Company;
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
                'code' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'mobile' => 'required',
                'g-recaptcha-response'  => 'required'
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $company = new Company;

        $company->company_code = $data['code'];
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
        $user->type = 1;

        $user->save();
//$this->notifyMerchant($user);
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
            'data-theme' => 'dark',
            'data-type' =>  'audio',
        ];

        return view('admin.register', compact('countries', 'attributes'));
    }

    /**
     * Send an email to Merchant that their registration needs admin approval
     */
    public function notifyMerchant($user)
    {
        Mail::send('admin.emails.notify-admin', ['user' => $user], function ($m) use ($user) {
            $m->from('ruby@icolumn.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }
}
