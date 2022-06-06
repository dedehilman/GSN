<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SymptomController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('symptom');
        $this->setSelect('master.symptom.select');
        $this->setIndex('master.symptom.index');
        $this->setCreate('master.symptom.create');
        $this->setEdit('master.symptom.edit');
        $this->setView('master.symptom.view');
        $this->setModel('App\Models\Symptom');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:symptoms',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:symptoms,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}