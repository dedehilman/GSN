<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class MedicineTypeController extends AppCrudController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('medicine-type');
        $this->setSelect('master.medicine-type.select');
        $this->setIndex('master.medicine-type.index');
        $this->setCreate('master.medicine-type.create');
        $this->setEdit('master.medicine-type.edit');
        $this->setView('master.medicine-type.view');
        $this->setModel('App\Models\MedicineType');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicine_types',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicine_types,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

