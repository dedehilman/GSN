<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class SickLetterController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('sick-letter');
        $this->setIndex('letter.sick-letter.index');
        $this->setCreate('letter.sick-letter.create');
        $this->setEdit('letter.sick-letter.edit');
        $this->setView('letter.sick-letter.view');
        $this->setModel('App\Models\SickLetter');
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
    	return $pdf->download($data->transaction_no.' '.$data->patient->name.'.pdf');
    }
}

