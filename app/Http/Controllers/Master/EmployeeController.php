<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('employee');
        $this->middleware('auth');
        $this->setSelect('master.employee.select');
        $this->setIndex('master.employee.index');
        $this->setCreate('master.employee.create');
        $this->setEdit('master.employee.edit');
        $this->setView('master.employee.view');
        $this->setModel('App\Models\Employee');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:employees',
            'name' => 'required|max:255',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:employees,code,'.$id,
            'name' => 'required|max:255',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
