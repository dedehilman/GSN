<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use LdapRecord\Connection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse()
    {
        $errors;
        $user = User::where('username', request()->username)->first();
        if($user) {
            if (!Hash::check(request()->password, $user->password)) {
                $errors['password'] = ['Password missmatch'];
            } else if ($user->enabled == 0) {
                $errors['username'] = ['User not active'];
            }
        } else {
            $errors['username'] = ['These credentials do not match our records'];
        }
        return redirect()->back()
            ->withInput(request()->only('username', 'remember'))
            ->withErrors($errors);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'enabled' => 1])) {
            return redirect()->intended($this->redirectTo);
        } else {
            $errors = [];
            if(getParameter("LDAP_AUTH") == "true") {
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
                    $username = $request->username;
                    //$username = $request->username;
                    $password = $request->password;
                    if ($connection->auth()->attempt($username, $password, $stayBound = true))
                    {
                        $query = $connection->query();
                        $recordDetail = $query->findBy("samaccountname", $request->username);
                        $user = User::where('username', $request->username)->first();
                        if($user) {
                            if ($user->enabled == 1) {
                                Auth::login($user);
                            } else {
                                $errors['username'] = ['User not active'];
                            }
                        } else {
                            if(getParameter("LDAP_AUTO_CREATE") == "true") {
                                if(User::where('username', $request->username)->first()) {
                                    $errors['username'] = ['Username already exist'];
                                } else {
                                    $user = new User();
                                    $user->name = $recordDetail['name'][0];
                                    $user->username = $request->username;
                                    $user->email = $recordDetail['mail'][0];
                                    $user->password = Hash::make($password);
                                    $user->save();
                                    Auth::login($user);
                                }
                            } else {
                                $errors['username'] = ['Data not found'];
                            }
                        }
                    } else {
                        $errors['username'] = ['These credentials do not match our records'];
                    }
                } catch (\Throwable $e) {
                    $error = $e->getDetailedError();
                    $errors['username'] = $error->getErrorMessage();                    
                }


                if(count($errors) > 0) {
                    return redirect()->back()
                        ->withInput(request()->only('username', 'remember'))
                        ->withErrors($errors);
                } else {
                    return redirect()->intended($this->redirectTo);
                }
            }
        }

        return $this->sendFailedLoginResponse();
    }
}
