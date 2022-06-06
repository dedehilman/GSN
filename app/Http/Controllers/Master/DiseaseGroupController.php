<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseGroupController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('disease-group');
        $this->setSelect('master.disease-group.select');
        $this->setIndex('master.disease-group.index');
        $this->setCreate('master.disease-group.create');
        $this->setEdit('master.disease-group.edit');
        $this->setView('master.disease-group.view');
        $this->setModel('App\Models\DiseaseGroup');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:disease_groups',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:disease_groups,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
