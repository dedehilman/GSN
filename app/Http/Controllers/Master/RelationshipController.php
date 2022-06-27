<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class RelationshipController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('relationship');
        $this->setSelect('master.relationship.select');
        $this->setIndex('master.relationship.index');
        $this->setCreate('master.relationship.create');
        $this->setEdit('master.relationship.edit');
        $this->setView('master.relationship.view');
        $this->setModel('App\Models\Relationship');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:relationships',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:relationships,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
