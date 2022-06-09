<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfdelinkController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('afdelink');
        $this->setSelect('master.afdelink.select');
        $this->setIndex('master.afdelink.index');
        $this->setCreate('master.afdelink.create');
        $this->setEdit('master.afdelink.edit');
        $this->setView('master.afdelink.view');
        $this->setModel('App\Models\Afdelink');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:afdelinks',
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:afdelinks,code,'.$id,
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

