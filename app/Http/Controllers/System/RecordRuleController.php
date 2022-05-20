<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class RecordRuleController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('record-rule');
        $this->setSelect('system.record-rule.select');
        $this->setIndex('system.record-rule.index');
        $this->setCreate('system.record-rule.create');
        $this->setEdit('system.record-rule.edit');
        $this->setView('system.record-rule.view');
        $this->setModel('App\Models\RecordRule');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:record_rules',
            'table' => 'required|max:255',
            'link' => 'required',
            'rule' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:record_rules,name,'.$id,
            'table' => 'required|max:255',
            'link' => 'required',
            'rule' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
