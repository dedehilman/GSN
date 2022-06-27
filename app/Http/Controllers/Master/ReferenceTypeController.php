<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferenceTypeController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('reference-type');
        $this->setSelect('master.reference-type.select');
        $this->setIndex('master.reference-type.index');
        $this->setCreate('master.reference-type.create');
        $this->setEdit('master.reference-type.edit');
        $this->setView('master.reference-type.view');
        $this->setModel('App\Models\ReferenceType');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:reference_types',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:reference_types,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
