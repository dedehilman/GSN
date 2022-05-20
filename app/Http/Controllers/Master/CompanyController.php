<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Site;
use App\Models\DepartmentMapping;
use App\Models\Location;

class CompanyController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('company');
        $this->setSelect('master.company.select');
        $this->setIndex('master.company.index');
        $this->setCreate('master.company.create');
        $this->setEdit('master.company.edit');
        $this->setView('master.company.view');
        $this->setModel('App\Models\Company');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:companies',
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:companies,code,'.$id,
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
