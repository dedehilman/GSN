<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use LdapRecord\Connection;
use Lang;

class AuthController extends Controller
{
    public function login(Request $request){
        $errors = [];
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = auth()->user();
            if($user->enabled == 1) {
                $token = auth()->user()->createToken('')->accessToken;
                return response()->json([
                    "status" => '200',
                    "message" => '',
                    "data" => $token,
                ]);
            } else {
                return response()->json([
                    "status" => '400',
                    "message" => Lang::get("User not active, please contact administrator"),
                    "data" => '',
                ]);
            }
        } else if(getParameter("LDAP_AUTH") == "true") {
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
                $password = $request->password;
                if ($connection->auth()->attempt($username, $password, $stayBound = true))
                {
                    $query = $connection->query();
                    $recordDetail = $query->findBy("samaccountname", $request->username);
                    $user = User::where('username', $request->username)->first();
                    if($user) {
                        if ($user->enabled == 1) {
                            $token = $user->createToken('')->accessToken;
                            return response()->json([
                                "status" => '200',
                                "message" => '',
                                "data" => $token,
                            ]);
                        } else {
                            return response()->json([
                                "status" => '400',
                                "message" => Lang::get("User not active, please contact administrator"),
                                "data" => '',
                            ]);
                        }
                    } else {
                        if(getParameter("LDAP_AUTO_CREATE") == "true") {
                            if(User::where('username', $request->username)->first()) {
                                return response()->json([
                                    "status" => '400',
                                    "message" => Lang::get("Username already exist"),
                                    "data" => '',
                                ]);
                            } else {
                                $user = new User();
                                $user->name = $recordDetail['name'][0];
                                $user->username = $request->username;
                                $user->email = $recordDetail['mail'][0];
                                $user->password = Hash::make($password);
                                $user->save();

                                $token = $user->createToken('')->accessToken;
                                return response()->json([
                                    "status" => '200',
                                    "message" => '',
                                    "data" => $token,
                                ]);
                            }
                        } else {
                            return response()->json([
                                "status" => '400',
                                "message" => Lang::get("These credentials do not match our records"),
                                "data" => '',
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        "status" => '400',
                        "message" => Lang::get("These credentials do not match our records"),
                        "data" => '',
                    ]);
                }
            } catch (\Throwable $e) {
                $error = $e->getDetailedError();
                return response()->json([
                    "status" => '500',
                    "message" => $error->getErrorMessage(),
                    "data" => '',
                ]);
            }
        } else {
            return response()->json([
                "status" => '400',
                "message" => Lang::get("These credentials do not match our records"),
                "data" => '',
            ]);
        }
    }

    public function logout(){
        $token = auth()->user()->token();
        $token->revoke();
        return response()->json([
            'status'=> '200',
            'message'=> Lang::get('You have been succesfully logged out'),
            'data'=> '',
        ]);
    }

    public function user(){
        $user = auth()->user();
        return response()->json([
            'status'=> '200',
            'message'=> '',
            'data'=> $user,
        ]);
    }
}
