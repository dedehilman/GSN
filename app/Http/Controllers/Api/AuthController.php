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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mail;
use Config;
use App\Traits\MailServerTrait;
use App\Models\MailHistory;
use Carbon\Carbon;
use LdapRecord\Models\ActiveDirectory\User as UserLDAP;
use App\Rules\MatchOldPassword;
use LdapRecord\Container;

class AuthController extends Controller
{
    use MailServerTrait;

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> '200',
                'message'=> $validator->errors()->all(),
                'data'=> '',
            ]);
        }

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
        $user = User::where('id', auth()->user()->id)->withAll()->first();
        return response()->json([
            'status'=> '200',
            'message'=> '',
            'data'=> $user,
        ]);
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> '200',
                'message'=> $validator->errors()->all(),
                'data'=> '',
            ]);
        }

        $user = User::where('username', $request->username)->first();
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

            return response()->json([
                'status'=> '200',
                'message'=> Lang::get("We have e-mailed your password reset link"),
                'data'=> '',
            ]);
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

                    return response()->json([
                        'status'=> '200',
                        'message'=> Lang::get("We have e-mailed your password reset link"),
                        'data'=> '',
                    ]);
                } else {
                    return response()->json([
                        'status'=> '200',
                        'message'=> Lang::get("Data not found"),
                        'data'=> '',
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status'=> '500',
                    'message'=> $th->getMessage(),
                    'data'=> '',
                ]);
            }
        } else {
            return response()->json([
                'status'=> '200',
                'message'=> Lang::get("Data not found"),
                'data'=> '',
            ]);
        }
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> '200',
                'message'=> $validator->errors()->all(),
                'data'=> '',
            ]);
        }

        $user;
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();
        if($passwordReset) {
            $user = User::where('email', $passwordReset->email)->first();
            if(!$user) {
                return response()->json([
                    'status'=> '200',
                    'message'=> Lang::get("Token not valid"),
                    'data'=> '',
                ]);
            }
        } else {
            return response()->json([
                'status'=> '200',
                'message'=> Lang::get("Token not valid"),
                'data'=> '',
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
                        $userLdap = UserLDAP::where("samaccountname", $user->username)->first();
                        if($userLdap) {
                            $userLdap->unicodepwd = $request->password;
                            $userLdap->save();    
                        } else {
                            return response()->json([
                                'status'=> '200',
                                'message'=> Lang::get("These credentials do not match our records"),
                                'data'=> '',
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status'=> '200',
                            'message'=> Lang::get("These credentials do not match our records"),
                            'data'=> '',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status'=> '200',
                        'message'=> Lang::get("These credentials do not match our records"),
                        'data'=> '',
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status'=> '500',
                    'message'=> $th->getMessage(),
                    'data'=> '',
                ]);
            }
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json([
            'status'=> '200',
            'message'=> Lang::get("Password has been changed"),
            'data'=> '',
        ]);
    }

    public function changePassword(Request $request) {
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
                        'message'=> $validator->errors()->all(),
                        'data' => '',
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
                            $user = UserLDAP::where("samaccountname", $currentUser->username)->first();
                            $user->unicodepwd = $request->new_password;
                            $user->save();
                        } else {
                            return response()->json([
                                'status' => '400',
                                'message'=> Lang::get("These credentials do not match our records"),
                                'data' => '',
                            ]);
                        }
                    } else {
                        Container::addConnection($connection);
                        $user = UserLDAP::where("samaccountname", $currentUser->username)->first();
                        $user->unicodepwd = $request->new_password;
                        $user->save();
                    }
                } else {
                    return response()->json([
                        'status' => '400',
                        'message'=> Lang::get("These credentials do not match our records"),
                        'data' => '',                        
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
                'message'=> Lang::get("Password has been changed"),
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }
}
