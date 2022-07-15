<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class MedicalStaffController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medical-staff');
        $this->setModel('App\Models\MedicalStaff');
    }
}
