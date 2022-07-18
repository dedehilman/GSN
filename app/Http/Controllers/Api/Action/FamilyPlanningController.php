<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Action\ActionController;
use Illuminate\Support\Facades\Validator;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use Lang;

class FamilyPlanningController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-family-planning');
        $this->setModel('App\Models\FamilyPlanning');
    }
}
