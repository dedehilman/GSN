<?php

namespace App\Http\Controllers\Api\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use Lang;
use Illuminate\Support\Str;

class FamilyPlanningController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('registration-family-planning');
        $this->setModel('App\Models\FamilyPlanning');
    }

    public function store(Request $request)
    {
        try {
            $transactionNo = FamilyPlanning::where('transaction_no', 'LIKE', 'KB-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-%')->orderBy('transaction_no', 'desc')->first();
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
                    'message'=> $validateOnStore,
                    'data' => '',
                ]);
            }

            $data = $this->model::create($request->all());
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been stored"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }        
    }

    public function addExtraAttribute($data) {
        foreach ($data as $dt) {
            $dt->setAttribute("action", $dt->action());
        }
    }

    public function setToDraft($id) {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $data->status = "Draft";
            $data->save();
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been set to Draft"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'transaction_no' => 'required|max:255|unique:family_plannings',
			'transaction_no' => 'required|max:255',
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
            // 'transaction_no' => 'required|max:255|unique:family_plannings,transaction_no,'.$id,
			'transaction_no' => 'required|max:255',
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
}
