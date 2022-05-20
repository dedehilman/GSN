<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\MatchOldPassword;
use Lang;
use LdapRecord\Connection;
use LdapRecord\Models\ActiveDirectory\User;
use LdapRecord\Container;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('system.change-password');
    }

    public function store(Request $request) {
        try {
            $currentUser = getCurrentUser();

            if($request->type == 'ldap') {
                $validator = Validator::make($request->all(), [
                    'current_password' => ['required'],
                    'new_password' => ['required'],
                    'new_confirm_password' => ['same:new_password'],
                ]);

                if($validator->fails()){
                    return response()->json([
                        'status' => '400',
                        'data' => '',
                        'message'=> $validator->errors()->all()
                    ]);
                }

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
                if ($connection->auth()->attempt($currentUser->username, $request->current_password, $stayBound = true))
                {
                    if(getParameter("LDAP_CHANGEPWD_USERNAME") && getParameter("LDAP_CHANGEPWD_PASSWORD")) {
                        if ($connection->auth()->attempt(getParameter("LDAP_CHANGEPWD_USERNAME"), getParameter("LDAP_CHANGEPWD_PASSWORD"), $stayBound = true))
                        {
                            Container::addConnection($connection);
                            $user = User::where("samaccountname", $currentUser->username)->first();
                            // $user->unicodepwd = [$request->current_password, $request->new_password];
                            $user->unicodepwd = $request->new_password;
                            $user->save();
                        } else {
                            return response()->json([
                                'status' => '400',
                                'data' => '',
                                'message'=> "These credentials do not match our records"
                            ]);
                        }
                    } else {
                        Container::addConnection($connection);
                        $user = User::where("samaccountname", $currentUser->username)->first();
                        // $user->unicodepwd = [$request->current_password, $request->new_password];
                        $user->unicodepwd = $request->new_password;
                        $user->save();
                    }
                } else {
                    return response()->json([
                        'status' => '400',
                        'data' => '',
                        'message'=> "These credentials do not match our records"
                    ]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'new_password' => ['required'],
                    'new_confirm_password' => ['same:new_password'],
                ]);
    
                if($currentUser->password) {
                    $validator = Validator::make($request->all(), [
                        'current_password' => ['required', new MatchOldPassword],
                        'new_password' => ['required'],
                        'new_confirm_password' => ['same:new_password'],
                    ]);    
                }
        
                if($validator->fails()){
                    return response()->json([
                        'status' => '400',
                        'data' => '',
                        'message'=> $validator->errors()->all()
                    ]);
                }
    
                $currentUser->password = Hash::make($request->new_password);
                $currentUser->save();    
            }

            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Password has been changed")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }
    }
}
