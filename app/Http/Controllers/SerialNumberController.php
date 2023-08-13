<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class SerialNumberController extends AppCrudController
{
    public function __construct()
    {
        // $this->setDefaultMiddleware('position');
        $this->setDefaultView('master.serial-number');
        $this->setSelect('master.serial-number.select');
        $this->setModel('App\Models\SerialNumber');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'number' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'number' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

}
