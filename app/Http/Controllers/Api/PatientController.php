<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class PatientController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('employee');
        $this->setModel('App\Models\Employee');
    }
}
