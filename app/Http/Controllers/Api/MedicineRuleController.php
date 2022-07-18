<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class MedicineRuleController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medicine-rule');
        $this->setModel('App\Models\MedicineRule');
    }
}
