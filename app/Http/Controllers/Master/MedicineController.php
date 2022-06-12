<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medicine');
        $this->setSelect('master.medicine.select');
        $this->setIndex('master.medicine.index');
        $this->setCreate('master.medicine.create');
        $this->setEdit('master.medicine.edit');
        $this->setView('master.medicine.view');
        $this->setModel('App\Models\Medicine');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicines',
            'name' => 'required|max:255',
            'medicine_type_id' => 'required',
            'unit_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicines,code,'.$id,
            'name' => 'required|max:255',
            'medicine_type_id' => 'required',
            'unit_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['medicine_type_id'])) {
            $query->where('medicine_type_id', $request->parameters['medicine_type_id']);
        }

        if(isset($request->parameters['unit_id'])) {
            $query->where('unit_id', $request->parameters['unit_id']);
        }

        return $query;
    }
}
