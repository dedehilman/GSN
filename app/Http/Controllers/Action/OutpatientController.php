<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\Outpatient;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;

class OutpatientController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-outpatient');
        $this->setDefaultView('action.outpatient');
        $this->setModel('App\Models\Outpatient');
    }
}

