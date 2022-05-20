<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ParameterController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('parameter');
        $this->setIndex('system.parameter.index');
        $this->setCreate('system.parameter.create');
        $this->setEdit('system.parameter.edit');
        $this->setView('system.parameter.view');
        $this->setModel('App\Models\Parameter');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|max:255|unique:parameters',
            'value' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|max:255|unique:parameters,key,'.$id,
            'value' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
