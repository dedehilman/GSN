<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class PositionController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('position');
        $this->setSelect('master.position.select');
        $this->setIndex('master.position.index');
        $this->setCreate('master.position.create');
        $this->setEdit('master.position.edit');
        $this->setView('master.position.view');
        $this->setModel('App\Models\Position');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:positions',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:positions,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
