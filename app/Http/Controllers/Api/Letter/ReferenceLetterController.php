<?php

namespace App\Http\Controllers\Api\Letter;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\ReferenceLetter;
use Carbon\Carbon;
use Lang;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use PDF;
use App\Traits\MailServerTrait;

class ReferenceLetterController extends ApiController
{

    use MailServerTrait;

    public function __construct()
    {
        $this->setDefaultMiddleware('reference-letter');
        $this->setModel('App\Models\ReferenceLetter');
    }

    public function store(Request $request)
    {
        try {
            $count = ReferenceLetter::whereDate('transaction_date', Carbon::parse($request->transaction_date)->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'SR-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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

    public function generate(Request $request)
    {
        try {
            $count = ReferenceLetter::whereDate('transaction_date', Carbon::parse($request->transaction_date)->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'SR-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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

    public function sendToEmail(Request $request)
    {
        try {
            $data = $this->model::find($request->id); 
            if($data) {
                $pdf = PDF::loadview('letter.reference-letter.template', ['data'=>$data]);
                Storage::put('public/letter/reference-letter/'.$data->transaction_no.'.pdf', $pdf->output());
                $params = array();
                $content = getParameter("REFERENCE_LETTER_CONTENT") ?? '';
                $params['title'] = $data->transaction_no;
                
                $params['attachment'] = Storage::path('public/letter/reference-letter/'.$data->transaction_no.'.pdf');
                $email = "";
                if($request->email && $request->name) {
                    $content = str_replace('{Recipient Name}', $request->name, $content);
                    $params['content'] = $content;
                    $email = $request->email;
                } 
                else if($data->for_relationship == 0 && $data->patient->email) {
                    $content = str_replace('{Recipient Name}', $data->patient->name, $content);
                    $params['content'] = $content;
                    $email = $data->patient->email;
                }
                else if($data->for_relationship == 1 && $data->patientRelationship->email) {
                    $content = str_replace('{Recipient Name}', $data->patientRelationship->name, $content);
                    $params['content'] = $content;
                    $email = $data->patientRelationship->email;
                }

                $this->setMailConfig();
                Mail::to($email)->send(new AppMail($params));
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
