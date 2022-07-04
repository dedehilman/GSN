<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\WorkAccident;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;

class WorkAccidentController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-work-accident');
        $this->setDefaultView('action.work-accident');
        $this->setModel('App\Models\WorkAccident');
    }
}

