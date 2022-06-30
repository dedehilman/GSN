<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Lang;

class UserController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('user');
        $this->setDefaultView('system.user');
        $this->setSelect('system.user.select');
        $this->setModel('App\Models\User');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        return view($this->index, compact('roles'));
    }

    public function create(Request $request)
    {
        $roles = Role::all();
        return view($this->create, compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }
            
            DB::beginTransaction();
            $data = new User();
            $data->username = $request->username;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->password = Hash::make($request->password);
            $data->enabled = $request->enabled ?? 0;

            $data->save();
            $data->syncRoles($request->roles);
            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $roles = Role::all();
        return view($this->edit, compact('data', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnUpdate
                ]);
            }

            DB::beginTransaction();
            $data->username = $request->username;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            if($request->password){
                $data->password = Hash::make($request->password);
            }
            $data->enabled = $request->enabled;

            $data->save();
            $data->syncRoles($request->roles);
            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been updated")
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }     
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            "roles" => "required|array|min:1"
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:users,username,'.$id,
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'max:255',
            "roles" => "required|array|min:1"
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        $username = $request->parameters['username'] ?? "";        
        $name = $request->parameters['name'] ?? "";
        $query->where(function($query) use ($username) 
        {
            $query->where('username','LIKE',"%{$username}%");
        });
        $query->where(function($query) use ($name) 
        {
            $query->where('name','LIKE',"%{$name}%");
        });
        if(isset($request->parameters['enabled'])) {
            $query->whereIn('enabled', $request->parameters['enabled']);
        }
        if(isset($request->parameters['role_id'])) {
            $roleId = $request->parameters['role_id'];
            $data = $query->whereHas('roles', function($q) use ($roleId) {
                $q->where('id', $roleId);
            });
        }
        return $query;
    }
}
