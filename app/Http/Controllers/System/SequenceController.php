<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\Sequence;
use App\Models\SequencePeriod;
use Illuminate\Support\Facades\DB;
use Lang;

class SequenceController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('sequence');
        $this->setSelect('system.sequence.select');
        $this->setIndex('system.sequence.index');
        $this->setCreate('system.sequence.create');
        $this->setEdit('system.sequence.edit');
        $this->setView('system.sequence.view');
        $this->setModel('App\Models\Sequence');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:sequences',
            'format' => 'required|max:255',
            'number_increment' => 'required',
            'number_next' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:sequences,name,'.$id,
            'format' => 'required|max:255',
            'number_increment' => 'required',
            'number_next' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
