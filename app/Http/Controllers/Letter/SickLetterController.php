<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Lang;
use Carbon\Carbon;
use App\Models\SickLetter;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use App\Models\Action;
use App\Traits\MailServerTrait;

class SickLetterController extends AppCrudController
{

    use MailServerTrait;

    public function __construct()
    {
        $this->setDefaultMiddleware('sick-letter');
        $this->setDefaultView('letter.sick-letter');
        $this->setModel('App\Models\SickLetter');
    }

    public function store(Request $request)
    {
        try {
            $count = SickLetter::whereDate('transaction_date', Carbon::parse($request->transaction_date)->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'SKS-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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
            'transaction_no' => 'required|max:255|unique:sick_letters',
            'transaction_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'num_of_days' => 'required',
            'remark'=> 'max:255'
        ]);

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
            'transaction_no' => 'required|max:255|unique:sick_letters,transaction_no,'.$id,
            'transaction_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'num_of_days' => 'required',
            'remark'=> 'max:255'
        ]);

        if($request->for_relationship == 1) {
            $validator->addRules([
                'patient_relationship_id'=> 'required'
            ]);
        }

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function download($id)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $pdf = PDF::loadview('letter.sick-letter.template', ['data'=>$data]);
    	return $pdf->download($data->transaction_no.'.pdf');
    }

    public function sendToEmail(Request $request)
    {
        try {
            $data = $this->model::find($request->id);
            if($data) {
                $pdf = PDF::loadview('letter.sick-letter.template', ['data'=>$data]);
                Storage::put('public/letter/sick-letter/'.$data->transaction_no.'.pdf', $pdf->output());
                $params = array();
                $content = getParameter("SICK_LETTER_CONTENT") ?? '';
                $params['title'] = $data->transaction_no;
                
                $params['attachment'] = Storage::path('public/letter/sick-letter/'.$data->transaction_no.'.pdf');
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
            dd($th);
            return redirect()->back()->with(['info' => $th->getMessage()]);
        }   
    }

    public function generate(Request $request) {
        $data = $request->model_type::find($request->model_id);
        $action = Action::where('model_type', $request->model_type)
                    ->where('model_id', $request->model_id)
                    ->first();

        return view("letter.sick-letter.generate", [
            "data" => $data,
            "action" => $action,
        ]);
    }

    public function generateStore(Request $request) {
        try {
            $count = SickLetter::whereDate('transaction_date', Carbon::parse($request->transaction_date)->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'SKS-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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
}

