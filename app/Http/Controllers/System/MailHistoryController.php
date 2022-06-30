<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;

class MailHistoryController extends AppCrudController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('mail-history');
        $this->setDefaultView('system.mail-history');
        $this->setModel('App\Models\MailHistory');
    }
}
