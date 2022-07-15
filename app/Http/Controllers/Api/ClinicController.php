<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class ClinicController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('clinic');
        $this->setModel('App\Models\Clinic');
    }
}
