<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstateController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('estate');
        $this->setSelect('master.estate.select');
        $this->setIndex('master.estate.index');
        $this->setCreate('master.estate.create');
        $this->setEdit('master.estate.edit');
        $this->setView('master.estate.view');
        $this->setModel('App\Models\Estate');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:estates',
            'name' => 'required|max:255',
            'company_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:estates,code,'.$id,
            'name' => 'required|max:255',
            'company_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

