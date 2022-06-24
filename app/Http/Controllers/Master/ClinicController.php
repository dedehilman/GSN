<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('clinic');
        $this->setSelect('master.clinic.select');
        $this->setIndex('master.clinic.index');
        $this->setCreate('master.clinic.create');
        $this->setEdit('master.clinic.edit');
        $this->setView('master.clinic.view');
        $this->setModel('App\Models\Clinic');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:clinics',
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:clinics,code,'.$id,
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

