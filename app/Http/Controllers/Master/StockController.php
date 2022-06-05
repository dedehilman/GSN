<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('stock');
        $this->setSelect('master.stock.select');
        $this->setIndex('master.stock.index');
        $this->setCreate('master.stock.create');
        $this->setEdit('master.stock.edit');
        $this->setView('master.stock.view');
        $this->setModel('App\Models\Stock');
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

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['period_id'])) {
            $query->where('period_id', $request->parameters['period_id']);
        }

        if(isset($request->parameters['medicine_id'])) {
            $query->where('medicine_id', $request->parameters['medicine_id']);
        }

        if(isset($request->parameters['clinic_id'])) {
            $query->where('clinic_id', $request->parameters['clinic_id']);
        }

        return $query;
    }
}
