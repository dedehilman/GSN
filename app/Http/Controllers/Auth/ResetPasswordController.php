<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use LdapRecord\Connection;
use LdapRecord\Models\ActiveDirectory\User;
use LdapRecord\Container;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
    {
        $message = "";
        $username = "";
        $passwordReset = DB::table('password_resets')->where('token', $token)->first();
        if($passwordReset) {
            $user = DB::table('users')->where('email', $passwordReset->email)->first();
            if($user) {
                $username = $user->username ?? "";
            } else {
                $message = "Token not valid";
            }
        } else {
            $message = "Token not valid";
        }

        return view('auth.passwords.reset')->with([
            'token' => $token, 
            'username' => $username,
            'message' => $message,
        ]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->input())->withErrors($validator->errors());
        }

        $user;
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();
        if($passwordReset) {
            $user = DB::table('users')->where('email', $passwordReset->email)->first();
            if(!$user) {
                return redirect()->back()->withInput($request->input())->with([
                    'messsage' => 'Token not valid'
                ]);
            }
        } else {
            return redirect()->back()->withInput($request->input())->with([
                'messsage' => 'Token not valid'
            ]);
        }

        if($request->type == 'ldap') {
            try {
                $connection = new Connection([
                    'hosts'            => [getParameter("LDAP_HOST")],
                    'base_dn'          => getParameter("LDAP_BASE_DN"),
                    'username'         => getParameter("LDAP_USERNAME") == "null" ? null : getParameter("LDAP_USERNAME"),
                    'password'         => getParameter("LDAP_PASSWORD") == "null" ? null : getParameter("LDAP_PASSWORD"),
                    'port'             => (int)getParameter("LDAP_PORT"),
                    'use_ssl'          => getParameter("LDAP_SSL") == "true" ? true : false,
                    'use_tls'          => getParameter("LDAP_TLS") == "true" ? true : (getParameter("LDAP_SSL") != "true" ? true : false),
                    'timeout'          => (int)getParameter("LDAP_TIMEOUT"),
                    'options' => [
                        LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER
                    ]
                ]);

                $connection->connect();
                if(getParameter("LDAP_CHANGEPWD_USERNAME") && getParameter("LDAP_CHANGEPWD_PASSWORD")) {
                    if ($connection->auth()->attempt(getParameter("LDAP_CHANGEPWD_USERNAME"), getParameter("LDAP_CHANGEPWD_PASSWORD"), $stayBound = true))
                    {
                        Container::addConnection($connection);
                        $userLdap = User::where("samaccountname", $user->username)->first();
                        if($userLdap) {
                            $userLdap->unicodepwd = $request->password;
                            $userLdap->save();    
                        } else {
                            return redirect()->back()->withInput($request->input())->with([
                                'messsage' => 'These credentials do not match our records'
                            ]);
                        }
                    } else {
                        return redirect()->back()->withInput($request->input())->with([
                            'messsage' => 'These credentials do not match our records'
                        ]);
                    }
                } else {
                    return redirect()->back()->withInput($request->input())->with([
                        'messsage' => 'These credentials do not match our records'
                    ]);
                }
            } catch (\Throwable $th) {
                return redirect()->back()->withInput($request->input())->with([
                    'messsage' => $th->getMessage()
                ]);
            }
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Password has been changed');
    }
}
