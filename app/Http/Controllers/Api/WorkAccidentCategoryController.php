<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class WorkAccidentCategoryController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('work-accident-category');
        $this->setModel('App\Models\WorkAccidentCategory');
    }
}
