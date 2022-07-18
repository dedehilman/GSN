<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class SymptomController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('symptom');
        $this->setModel('App\Models\Symptom');
    }
}
