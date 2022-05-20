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
        $this->setIndex('system.job.index');
        $this->setView('system.job.view');
        $this->setModel('App\Models\Job');
    }
}
