<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class MedicineRuleController extends AppCrudController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('medicine-rule');
        $this->setSelect('master.medicine-rule.select');
        $this->setIndex('master.medicine-rule.index');
        $this->setCreate('master.medicine-rule.create');
        $this->setEdit('master.medicine-rule.edit');
        $this->setView('master.medicine-rule.view');
        $this->setModel('App\Models\MedicineRule');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicine_rules',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicine_rules,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
