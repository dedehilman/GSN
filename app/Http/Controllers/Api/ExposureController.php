<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class ExposureController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('exposure');
        $this->setModel('App\Models\Exposure');
    }
}
