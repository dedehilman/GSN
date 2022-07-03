<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamilyPlanningCategoryController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('family-planning-category');
        $this->setDefaultView('master.family-planning-category');
        $this->setSelect('master.family-planning-category.select');
        $this->setModel('App\Models\FamilyPlanningCategory');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:family_planning_categories',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:family_planning_categories,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

