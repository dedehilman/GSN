<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;

class FamilyPlanningController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-family-planning');
        $this->setDefaultView('action.family-planning');
        $this->setModel('App\Models\FamilyPlanning');
    }
}

