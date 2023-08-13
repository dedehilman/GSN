<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ProductTypeController extends AppCrudController
{
    public function __construct()
    {
        // $this->setDefaultMiddleware('position');
        $this->setDefaultView('master.product-type');
        $this->setSelect('master.product-type.select');
        $this->setModel('App\Models\ProductType');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
