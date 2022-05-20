<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Department;

class DepartmentController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('department');
        $this->setSelect('master.department.select');
        $this->setIndex('master.department.index');
        $this->setCreate('master.department.create');
        $this->setEdit('master.department.edit');
        $this->setView('master.department.view');
        $this->setModel('App\Models\Department');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:departments',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:departments,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function getTreeview(Request $request)
    {
        try
        {
            $data = Department::select(
                    'id',
                    'code',
                    'name',
                    DB::Raw('CONCAT(COALESCE(code,""), " ", COALESCE(name, "")) AS text'),
                    DB::Raw('COALESCE(parent_id, "#") AS parent')
                )->get();
            
            return $data;
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }
}
