<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Action\ActionController;
use Illuminate\Support\Facades\Validator;
use App\Models\Outpatient;
use Carbon\Carbon;
use Lang;

class OutpatientController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-outpatient');
        $this->setModel('App\Models\Outpatient');
    }
}
