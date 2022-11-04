<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Str;

class FamilyPlanningController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('registration-family-planning');
        $this->setDefaultView('registration.family-planning');
        $this->setModel('App\Models\FamilyPlanning');
    }

    public function store(Request $request)
    {
        try {
			$transactionNo = FamilyPlanning::whereDate('transaction_date', $request->transaction_date)->orderBy('transaction_no', 'desc')->first();
			$count = 0;
			try {
				$count = (int) Str::substr($transactionNo->transaction_no, -5);				
			} catch (\Throwable $th) {
			}
            $request['transaction_no'] = 'KB-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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
            'transaction_no' => 'required|max:255|unique:family_plannings',
            'transaction_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'reference_type' => 'required',
        ]);

        if($request->reference_type == 'Internal') {
            $validator->addRules([
                'reference_clinic_id'=> 'required'
            ]);
        } else if($request->reference_type == 'External') {
            $validator->addRules([
                'reference_id'=> 'required',
            ]);
        }

        if($request->for_relationship == 1) {
            $validator->addRules([
                'patient_relationship_id'=> 'required'
            ]);
        }

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'transaction_no' => 'required|max:255|unique:family_plannings,transaction_no,'.$id,
            'transaction_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'reference_type' => 'required',
        ]);

        if($request->reference_type == 'Internal') {
            $validator->addRules([
                'reference_clinic_id'=> 'required'
            ]);
        } else if($request->reference_type == 'External') {
            $validator->addRules([
                'reference_id'=> 'required',
            ]);
        }

        if($request->for_relationship == 1) {
            $validator->addRules([
                'patient_relationship_id'=> 'required'
            ]);
        }

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function download($id, Request $request)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $transactionNo = explode("-", $data->transaction_no);
        $queue = intval($transactionNo[count($transactionNo)-1]);
        $pdf = PDF::loadview('registration.'.$request->type, [
            'data' => $data,
            'clinic' => $data->clinic,
            'patient' => $data->for_relationship == 0 ? $data->patient : $data->patientRelationship,
            'service' => "KB",
            'queue' => $queue
        ]);

        return $pdf->download($data->transaction_no.'.pdf');
    }
}

