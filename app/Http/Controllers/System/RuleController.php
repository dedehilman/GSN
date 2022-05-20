<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class RuleController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('rule');
        $this->setSelect('system.rule.select');
        $this->setIndex('system.rule.index');
        $this->setCreate('system.rule.create');
        $this->setEdit('system.rule.edit');
        $this->setView('system.rule.view');
        $this->setModel('App\Models\Rule');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:rules',
            'rule' => 'max:255',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:rules,name,'.$id,
            'rule' => 'max:255',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
