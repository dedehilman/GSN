<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\PlanoTest;
use Carbon\Carbon;
use Lang;

class PlanoTestController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-plano-test');
        $this->setModel('App\Models\PlanoTest');
    }
}
