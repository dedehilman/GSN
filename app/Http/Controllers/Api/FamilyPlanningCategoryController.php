<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;

class FamilyPlanningCategoryController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('family-planning-category');
        $this->setModel('App\Models\FamilyPlanningCategory');
    }
}
