<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\WorkAccident;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Str;

class WorkAccidentController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('registration-work-accident');
        $this->setDefaultView('registration.work-accident');
        $this->setModel('App\Models\WorkAccident');
    }

    public function store(Request $request)
    {
        try {
			$transactionNo = WorkAccident::where('transaction_no', 'LIKE', 'KK-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-%')->orderBy('transaction_no', 'desc')->first();
			$count = 0;
			try {
				$count = (int) Str::substr($transactionNo->transaction_no, -5);				
			} catch (\Throwable $th) {
			}
            $request['transaction_no'] = 'KK-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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
            // 'transaction_no' => 'required|max:255|unique:work_accidents',
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
            // 'transaction_no' => 'required|max:255|unique:work_accidents,transaction_no,'.$id,
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
            'service' => "Kecelakaan Kerja",
            'queue' => $queue
        ]);

        return $pdf->download($data->transaction_no.'.pdf');
    }

    public function edit(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        if($data->status == "Publish") {
            if(Str::contains($request->path(), '/edit')) {
                return redirect(route('registration.work-accident.show', $data->id));
            }
        }
        return view($this->edit, compact('data'));
    }

    public function setToDraft($id) {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $data->status = "Draft";
        $data->save();
        return redirect()->back()->with(['success' => Lang::get("Data has been set to Draft")]);
    }
}

