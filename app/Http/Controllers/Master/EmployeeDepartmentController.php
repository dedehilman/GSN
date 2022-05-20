<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class EmployeeDepartmentController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('employee-department');
        $this->setIndex('master.employee-department.index');
        $this->setCreate('master.employee-department.create');
        $this->setEdit('master.employee-department.edit');
        $this->setView('master.employee-department.view');
        $this->setModel('App\Models\EmployeeDepartment');
        $this->setParentModel('App\Models\Employee');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'effective_date' => 'required',
            'department_id' => 'required',
            'employee_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'effective_date' => 'required',
            'department_id' => 'required',
            'employee_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['effective_date']) && isset($request->parameters['expiry_date'])) {
            $effectiveDate = $request->parameters['effective_date'];
            $expiryDate = $request->parameters['expiry_date'];
            $query->where(function($query) use($effectiveDate, $expiryDate)
            {
                $query->whereRaw('? between effective_date and expiry_date', $effectiveDate);
                $query->orWhereRaw('? between effective_date and expiry_date', $expiryDate);
            });
        } else if(isset($request->parameters['effective_date'])) {
            $query->whereRaw('? between effective_date and expiry_date', $request->parameters['effective_date']);
        } else if(isset($request->parameters['expiry_date'])) {
            $query->whereRaw('? between effective_date and expiry_date', $request->parameters['expiry_date']);
        }
        if(isset($request->parameters['department_id'])) {
            $query->where('department_id', $request->parameters['department_id']);
        }

        return $query;
    }
}
