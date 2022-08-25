<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class DiseaseMedicineController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('disease');
        $this->setModel('App\Models\DiseaseMedicine');
    }
}
