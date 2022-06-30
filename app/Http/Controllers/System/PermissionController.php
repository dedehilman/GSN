<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class PermissionController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('permission');
        $this->setDefaultView('system.permission');
        $this->setSelect('system.permission.select');
        $this->setModel('App\Models\Permission');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:permissions',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:permissions,name,'.$id,
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
