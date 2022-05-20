<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class AttributeController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('attribute');
        $this->setSelect('master.attribute.select');
        $this->setIndex('master.attribute.index');
        $this->setCreate('master.attribute.create');
        $this->setEdit('master.attribute.edit');
        $this->setView('master.attribute.view');
        $this->setModel('App\Models\Attribute');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:attributes',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:attributes,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
