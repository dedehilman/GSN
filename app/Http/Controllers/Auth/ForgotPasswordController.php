<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use LdapRecord\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use Config;
use App\Traits\MailServerTrait;
use App\Models\MailHistory;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, MailServerTrait;

    public function sendResetLinkEmail(Request $request)
    {
        $errors = [];        
        $user = User::where('username', request()->username)->first();
        $token = Str::random(60);
        if($user) {
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            MailHistory::create([
                "to"=> $user->email,
                "cc"=> null,
                "subject"=> "Reset Password",
                "body"=> view('mail.forgot-password', compact('token', 'user'))->render(),
            ]);
    
            $this->setMailConfig();
            Mail::send('mail.forgot-password', ['token' => $token, 'user' => $user], function($message) use($user){
                $message->to($user->email);
                $message->subject('Reset Password');
            });
            return redirect()->back()->with('success', 'We have e-mailed your password reset link!');
        } else if(getParameter("LDAP_AUTH") == "true" && getParameter("LDAP_AUTO_CREATE") == "true") {
            $connection = new Connection([
                'hosts'            => [getParameter("LDAP_HOST")],
                'base_dn'          => getParameter("LDAP_BASE_DN"),
                'username'         => getParameter("LDAP_USERNAME") == "null" ? null : getParameter("LDAP_USERNAME"),
                'password'         => getParameter("LDAP_PASSWORD") == "null" ? null : getParameter("LDAP_PASSWORD"),
                'port'             => (int)getParameter("LDAP_PORT"),
                'use_ssl'          => getParameter("LDAP_SSL") == "true" ? true : false,
                'use_tls'          => getParameter("LDAP_TLS") == "true" ? true : false,
                'timeout'          => (int)getParameter("LDAP_TIMEOUT"),
                'options' => [
                    LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER
                ]
            ]);

            try {
                $connection->connect();
                $query = $connection->query();
                $recordDetail = $query->findBy("samaccountname", $request->username);
                if($recordDetail) {
                    $user = new User();
                    $user->name = $recordDetail['name'][0];
                    $user->username = $request->username;
                    $user->email = $recordDetail['mail'][0];
                    $user->password = Hash::make($request->username);
                    $user->save();

                    DB::table('password_resets')->insert([
                        'email' => $user->email,
                        'token' => $token,
                        'created_at' => Carbon::now(),
                    ]);
                    
                    MailHistory::create([
                        "to"=> $user->email,
                        "cc"=> null,
                        "subject"=> "Reset Password",
                        "body"=> view('mail.forgot-password', compact('token', 'user'))->render(),
                    ]);
            
                    $this->setMailConfig();
                    Mail::send('mail.forgot-password', ['token' => $token, 'user' => $user], function($message) use($user){
                        $message->to($user->email);
                        $message->subject('Reset Password');
                    });
                    return redirect()->back()->with('success', 'We have e-mailed your password reset link!');
                } else {
                    $errors['username'] = ['Username not found'];
                }
            } catch (\Throwable $th) {
                $errors['username'] = $th->getMessage();
            }
        } else {
            $errors['username'] = ['Username not found'];
        }

        return redirect()->back()
                ->withInput(request()->only('username'))
                ->withErrors($errors);
    }


}
