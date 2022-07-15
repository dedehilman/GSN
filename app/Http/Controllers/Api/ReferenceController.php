<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class ReferenceController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('reference');
        $this->setModel('App\Models\Reference');
    }
}
