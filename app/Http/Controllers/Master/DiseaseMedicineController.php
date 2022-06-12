<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiseaseMedicineController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('disease-medicine');
        $this->setSelect('master.disease-medicine.select');
        $this->setIndex('master.disease-medicine.index');
        $this->setCreate('master.disease-medicine.create');
        $this->setEdit('master.disease-medicine.edit');
        $this->setView('master.disease-medicine.view');
        $this->setModel('App\Models\DiseaseMedicine');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'disease_id' => 'required',
            'medicine_id' => 'required',
            'medicine_rule_id' => 'required',
            'qty' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'disease_id' => 'required',
            'medicine_id' => 'required',
            'medicine_rule_id' => 'required',
            'qty' => 'required',
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

        if(isset($request->parameters['medicine_id'])) {
            $query->where('medicine_id', $request->parameters['medicine_id']);
        }

        if(isset($request->parameters['medicine_rule_id'])) {
            $query->where('medicine_rule_id', $request->parameters['medicine_rule_id']);
        }

        return $query;
    }
}
