<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ProductController extends AppCrudController
{
    public function __construct()
    {
        // $this->setDefaultMiddleware('position');
        $this->setDefaultView('master.product');
        $this->setSelect('master.product.select');
        $this->setModel('App\Models\Product');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'name' => 'required|max:255',
            'stock' => 'required',
            'merk' => 'required|max:255',

        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'name' => 'required|max:255',
            'stock' => 'required',
            'merk' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
