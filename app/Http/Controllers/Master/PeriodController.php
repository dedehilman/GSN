<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('period');
        $this->setDefaultView('master.period');
        $this->setSelect('master.period.select');
        $this->setModel('App\Models\Period');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:periods',
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:periods,code,'.$id,
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['start_date']) && isset($request->parameters['end_date'])) {
            $startDate = $request->parameters['start_date'];
            $endDate = $request->parameters['end_date'];
            $query->where(function($query) use($startDate, $endDate)
            {
                $query->whereRaw('? between start_date and end_date', $startDate);
                $query->orWhereRaw('? between start_date and end_date', $endDate);
            });
        } else if(isset($request->parameters['start_date'])) {
            $query->whereRaw('? between start_date and end_date', $request->parameters['start_date']);
        } else if(isset($request->parameters['end_date'])) {
            $query->whereRaw('? between start_date and end_date', $request->parameters['end_date']);
        }

        return $query;
    }
}
