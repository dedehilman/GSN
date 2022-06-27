<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferenceController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('reference');
        $this->setSelect('master.reference.select');
        $this->setIndex('master.reference.index');
        $this->setCreate('master.reference.create');
        $this->setEdit('master.reference.edit');
        $this->setView('master.reference.view');
        $this->setModel('App\Models\Reference');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:references',
            'name' => 'required|max:255',
            'reference_type_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:references,code,'.$id,
            'name' => 'required|max:255',
            'reference_type_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
