<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('disease');
        $this->setSelect('master.disease.select');
        $this->setIndex('master.disease.index');
        $this->setCreate('master.disease.create');
        $this->setEdit('master.disease.edit');
        $this->setView('master.disease.view');
        $this->setModel('App\Models\Disease');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:diseases',
            'name' => 'required|max:255',
            'disease_group_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:diseases,code,'.$id,
            'name' => 'required|max:255',
            'disease_group_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

