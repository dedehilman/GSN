<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeRelationshipController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('employee-relationship');
        $this->setSelect('master.employee.relationship-select');
        $this->setModel('App\Models\EmployeeRelationship');
    }
}

