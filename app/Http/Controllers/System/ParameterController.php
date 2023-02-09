<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use Lang;
use Illuminate\Support\Facades\Crypt;

class ParameterController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('parameter');
        $this->setDefaultView('system.parameter');
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
            
            if(($request->encrypted ?? 0) == 1) {
                $request['value'] = Crypt::encryptString($request->value);
            }

            $this->model::create($request->all());
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
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
