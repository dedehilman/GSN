<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;

class MailHistoryController extends AppCrudController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('mail-history');
        $this->setIndex('system.mail-history.index');
        $this->setView('system.mail-history.view');
        $this->setModel('App\Models\MailHistory');
    }
}
