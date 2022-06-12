<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosisSymptomController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('diagnosis-symptom');
        $this->setSelect('master.diagnosis-symptom.select');
        $this->setIndex('master.diagnosis-symptom.index');
        $this->setCreate('master.diagnosis-symptom.create');
        $this->setEdit('master.diagnosis-symptom.edit');
        $this->setView('master.diagnosis-symptom.view');
        $this->setModel('App\Models\DiagnosisSymptom');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diagnosis_id' => 'required',
            'symptom_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'diagnosis_id' => 'required',
            'symptom_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['diagnosis_id'])) {
            $query->where('diagnosis_id', $request->parameters['diagnosis_id']);
        }

        if(isset($request->parameters['symptom_id'])) {
            $query->where('symptom_id', $request->parameters['symptom_id']);
        }

        return $query;
    }
}
