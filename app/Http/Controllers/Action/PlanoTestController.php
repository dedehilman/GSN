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
use App\Traits\MailServerTrait;

class PlanoTestController extends ActionController
{

    use MailServerTrait;
    
    public function __construct()
    {
        $this->setDefaultMiddleware('action-plano-test');
        $this->setDefaultView('action.plano-test');
        $this->setModel('App\Models\PlanoTest');
    }

    public function download($id)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $pdf = PDF::loadview('action.plano-test.template', ['data'=>$data]);
    	return $pdf->download($data->transaction_no.'.pdf');
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

            return redirect()->back()->with(['success' => Lang::get("Data has been send")]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['info' => $th->getMessage()]);
        }   
    }
}

