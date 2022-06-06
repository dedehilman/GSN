<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class UnitController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('unit');
        $this->setSelect('master.unit.select');
        $this->setIndex('master.unit.index');
        $this->setCreate('master.unit.create');
        $this->setEdit('master.unit.edit');
        $this->setView('master.unit.view');
        $this->setModel('App\Models\Unit');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:units',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:units,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
