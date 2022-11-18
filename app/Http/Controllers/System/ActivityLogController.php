<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class ActivityLogController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('activity-log');
        $this->setDefaultView('system.activity-log');
        $this->setModel('App\Models\ActivityLog');
    }
}
