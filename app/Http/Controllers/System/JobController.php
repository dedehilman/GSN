<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class JobController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('job');
        $this->setDefaultView('system.job');
        $this->setModel('App\Models\Job');
    }
}
