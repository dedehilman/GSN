<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ClientController extends AppCrudController
{
    public function __construct()
    {
        // $this->setDefaultMiddleware('position');
        $this->setDefaultView('master.client');
        $this->setSelect('master.client.select');
        $this->setModel('App\Models\Client');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required|max:255',

        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
