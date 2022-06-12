<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('diagnosis');
        $this->setSelect('master.diagnosis.select');
        $this->setIndex('master.diagnosis.index');
        $this->setCreate('master.diagnosis.create');
        $this->setEdit('master.diagnosis.edit');
        $this->setView('master.diagnosis.view');
        $this->setModel('App\Models\Diagnosis');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:diagnoses',
            'name' => 'required|max:255',
            'disease_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:diagnoses,code,'.$id,
            'name' => 'required|max:255',
            'disease_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['disease_id'])) {
            $query->where('disease_id', $request->parameters['disease_id']);
        }

        return $query;
    }
}
