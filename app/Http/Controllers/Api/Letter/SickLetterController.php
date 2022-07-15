<?php

namespace App\Http\Controllers\Api\Letter;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\SickLetter;
use Carbon\Carbon;
use Lang;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use PDF;

class SickLetterController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('sick-letter');
        $this->setModel('App\Models\SickLetter');
    }

    public function store(Request $request)
    {
        try {
            $count = SickLetter::whereDate('transaction_date', Carbon::now()->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'SKS-'.Carbon::now()->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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

    public function sendToEmail($id)
    {
        try {
            $data = $this->model::find($id); 
            if($data) {
                $pdf = PDF::loadview('letter.sick-letter.template', ['data'=>$data]);
                Storage::put('public/letter/sick-letter/'.$data->transaction_no.'.pdf', $pdf->output());
                $params = array();
                $content = getParameter("REFERENCE_LETTER_CONTENT") ?? '';
                $params['title'] = $data->transaction_no;
                
                $params['attachment'] = Storage::path('public/letter/sick-letter/'.$data->transaction_no.'.pdf');
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

            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been send"),
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }   
    }
}
