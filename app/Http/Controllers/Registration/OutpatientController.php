<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Registration;
use Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OutpatientController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('registration-outpatient');
        $this->setDefaultView('registration.outpatient');
        $this->setModel('App\Models\Registration');
        $this->addExtraParameter('registration_type', 'Outpatient');
    }

    public function store(Request $request)
    {
        try {
            $count = Registration::whereDate('registration_date', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('registration_type', 'Outpatient')->count();
            $request['registration_no'] = 'OP-'.Carbon::now()->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);
            $request['registration_type'] = 'Outpatient';

            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }
            $this->model::create($request->all());
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_no' => 'required|max:255|unique:registrations',
            'registration_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'reference_id'=> 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'registration_no' => 'required|max:255|unique:registrations,registration_no,'.$id,
            'registration_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'reference_id'=> 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

