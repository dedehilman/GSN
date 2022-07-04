<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\PlanoTest;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;

class PlanoTestController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-plano-test');
        $this->setDefaultView('action.plano-test');
        $this->setModel('App\Models\PlanoTest');
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validateOnStore = $this->validateOnStore($request);
    //         if($validateOnStore) {
    //             return response()->json([
    //                 'status' => '400',
    //                 'data' => '',
    //                 'message'=> $validateOnStore
    //             ]);
    //         }
    //         $this->model::create($request->all());
    //         return response()->json([
    //             'status' => '200',
    //             'data' => '',
    //             'message'=> Lang::get("Data has been stored")
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => '500',
    //             'data' => '',
    //             'message'=> $th->getMessage()
    //         ]);
    //     }        
    // }

    // public function validateOnStore(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'transaction_no' => 'required|max:255|unique:plano_tests',
    //         'transaction_date' => 'required',
    //         'clinic_id' => 'required',
    //         'patient_id' => 'required',
    //         'medical_staff_id' => 'required',
    //         'reference_type' => 'required',
    //     ]);

    //     if($request->reference_type == 'Internal') {
    //         $validator->addRules([
    //             'reference_clinic_id'=> 'required'
    //         ]);
    //     } else {
    //         $validator->addRules([
    //             'reference_id'=> 'required',
    //         ]);
    //     }

    //     if($request->for_relationship == 1) {
    //         $validator->addRules([
    //             'patient_relationship_id'=> 'required'
    //         ]);
    //     }

    //     if($validator->fails()){
    //         return $validator->errors()->all();
    //     }
    // }

    // public function validateOnUpdate(Request $request, int $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'transaction_no' => 'required|max:255|unique:plano_tests,transaction_no,'.$id,
    //         'transaction_date' => 'required',
    //         'clinic_id' => 'required',
    //         'patient_id' => 'required',
    //         'medical_staff_id' => 'required',
    //         'reference_type' => 'required',
    //     ]);

    //     if($request->reference_type == 'Internal') {
    //         $validator->addRules([
    //             'reference_clinic_id'=> 'required'
    //         ]);
    //     } else {
    //         $validator->addRules([
    //             'reference_id'=> 'required',
    //         ]);
    //     }

    //     if($request->for_relationship == 1) {
    //         $validator->addRules([
    //             'patient_relationship_id'=> 'required'
    //         ]);
    //     }

    //     if($validator->fails()){
    //         return $validator->errors()->all();
    //     }
    // }

    public function download($id)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $pdf = PDF::loadview('action.plano-test.template', ['data'=>$data]);
    	return $pdf->download($data->transaction_no.'.pdf');
    }

    public function sendToEmail($id)
    {
        try {
            $data = $this->model::find($id); 
            if($data) {
                $pdf = PDF::loadview('action.plano-test.template', ['data'=>$data]);
                Storage::put('public/plano-test/'.$data->transaction_no.'.pdf', $pdf->output());
                $params = array();
                $content = getParameter("PPT_LETTER_CONTENT") ?? '';
                $params['title'] = $data->transaction_no;
                
                $params['attachment'] = Storage::path('public/plano-test/'.$data->transaction_no.'.pdf');
                if($data->for_relationship == 0 && $data->patient->email) {
                    $content = str_replace('{Recipient Name}', $data->patient->name, $content);
                    $params['content'] = $content;
                    Mail::to($data->patient->email)->send(new AppMail($params));
                }
                else if($data->for_relationship == 1 && $data->patientRelationship->email) {
                    $content = str_replace('{Recipient Name}', $data->patientRelationship->name, $content);
                    $params['content'] = $content;
                    Mail::to($data->patientRelationship->email)->send(new AppMail($params));
                }
            }

            return redirect()->back()->with(['success' => Lang::get("Data has been send")]);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with(['info' => $th->getMessage()]);
        }   
    }
}

