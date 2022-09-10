<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class EstateController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('estate');
        $this->setModel('App\Models\Estate');
    }
}
