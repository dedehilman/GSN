<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class MenuController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('menu');
        $this->setSelect('system.menu.select');
        $this->setIndex('system.menu.index');
        $this->setCreate('system.menu.create');
        $this->setEdit('system.menu.edit');
        $this->setView('system.menu.view');
        $this->setModel('App\Models\Menu');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:menus|max:255',
            'title' => 'required|max:255',
            'link' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:menus,code,'.$id,
            'title' => 'required|max:255',
            'link' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
