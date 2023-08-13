<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ProjectController extends AppCrudController
{
    public function __construct()
    {
        // $this->setDefaultMiddleware('position');
        $this->setDefaultView('master.project');
        $this->setSelect('master.project.select');
        $this->setModel('App\Models\Project');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'client_id' => 'required',
            'project_name' => 'required|max:255',
            'product_id' => 'required',
            'serial_numbers' => 'required',
            'location' => 'required',
            'status' => 'required',

        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'client_id' => 'required',
            'project_name' => 'required|max:255',
            'product_id' => 'required',
            'serial_numbers' => 'required',
            'location' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
