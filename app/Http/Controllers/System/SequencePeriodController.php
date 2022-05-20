<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;

class SequencePeriodController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('sequence-period');
        $this->setIndex('system.sequence-period.index');
        $this->setCreate('system.sequence-period.create');
        $this->setEdit('system.sequence-period.edit');
        $this->setView('system.sequence-period.view');
        $this->setModel('App\Models\SequencePeriod');
        $this->setParentModel('App\Models\Sequence');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'effective_date' => 'required',
            'expiry_date' => 'required',
            'number_next' => 'required',
            'sequence_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'effective_date' => 'required',
            'expiry_date' => 'required',
            'number_next' => 'required',
            'sequence_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['effective_date']) && isset($request->parameters['expiry_date'])) {
            $effectiveDate = $request->parameters['effective_date'];
            $expiryDate = $request->parameters['expiry_date'];
            $query->where(function($query) use($effectiveDate, $expiryDate)
            {
                $query->whereRaw('? between effective_date and expiry_date', $effectiveDate);
                $query->orWhereRaw('? between effective_date and expiry_date', $expiryDate);
            });
        } else if(isset($request->parameters['effective_date'])) {
            $query->whereRaw('? between effective_date and expiry_date', $request->parameters['effective_date']);
        } else if(isset($request->parameters['expiry_date'])) {
            $query->whereRaw('? between effective_date and expiry_date', $request->parameters['expiry_date']);
        }

        return $query;
    }
}
