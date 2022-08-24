<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PlanoTest;
use Carbon\Carbon;
use Lang;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use App\Traits\MailServerTrait;
use Illuminate\Support\Facades\DB;

class PlanoTestController extends ActionController
{
    use MailServerTrait;

    public function __construct()
    {
        $this->setDefaultMiddleware('action-plano-test');
        $this->setModel('App\Models\PlanoTest');
    }

    public function store(Request $request)
    {
        try {
            $count = PlanoTest::whereDate('transaction_date', Carbon::now()->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'PPT-'.Carbon::now()->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }
            DB::beginTransaction();
            $data = $this->model::create($request->all());
            $this->documentHandler($data, $request);
            $this->actionHandler($data, $request);
            $this->prescriptionHandler($data, $request);
            $this->diagnosisHandler($data, $request);

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => $data,
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }

    public function sendToEmail(Request $request)
    {
        try {
            $data = $this->model::find($request->id); 
            if($data) {
                $pdf = PDF::loadview('action.plano-test.template', ['data'=>$data]);
                Storage::put('public/plano-test/'.$data->transaction_no.'.pdf', $pdf->output());
                $params = array();
                $content = getParameter("PPT_LETTER_CONTENT") ?? '';
                $params['title'] = $data->transaction_no;
                
                $params['attachment'] = Storage::path('public/plano-test/'.$data->transaction_no.'.pdf');
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
