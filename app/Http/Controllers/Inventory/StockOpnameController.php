<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockOpnameController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('stock-opname');
        $this->setDefaultView('inventory.stock-opname');
        $this->setModel('App\Models\StockOpname');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_id' => 'required',
            'medicine_id' => 'required',
            'clinic_id' => 'required',
            'qty' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'period_id' => 'required',
            'medicine_id' => 'required',
            'clinic_id' => 'required',
            'qty' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
