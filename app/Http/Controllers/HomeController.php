<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function sendMail()
    {
        $user = ['name' => 'Ruby', 'email' => 'bhinxy18@yahoo.com'];
        Mail::send('admin.emails.notify-admin', ['user' => $user], function ($m) use ($user) {
            $m->from('ruby@icolumn.com', 'Your Application');

            $m->to($user['email'], $user['name'])->subject('Your Reminder!');
        });
    }
}
