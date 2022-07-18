<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Action\ActionController;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkAccident;
use Carbon\Carbon;
use Lang;

class WorkAccidentController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-work-accident');
        $this->setModel('App\Models\WorkAccident');
    }
}
