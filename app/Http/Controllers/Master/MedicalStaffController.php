<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Lang;
use App\Models\MedicalStaff;
use App\Models\MedicalStaffClinic;

class MedicalStaffController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medical-staff');
        $this->setDefaultView('master.medical-staff');
        $this->setSelect('master.medical-staff.select');
        $this->setModel('App\Models\MedicalStaff');
    }

    public function store(Request $request)
    {
        try {
            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }

            DB::beginTransaction();
            $data = new MedicalStaff();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->gender = $request->gender;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->clinic_id = $request->clinic_id;
            if($request->image) {
                $file = $request->file('image');
                $tujuan_upload = 'public/img/medical-staff';
                if($file->move($tujuan_upload, time().'_'.$file->getClientOriginalName())) {
                    $data->image = 'public/img/medical-staff/'.time().'_'.$file->getClientOriginalName();
                };
            }
            $data->save();

            $data->syncClinics($request->clinics);

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
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

    public function update(Request $request, $id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnUpdate
                ]);
            }

            DB::beginTransaction();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->gender = $request->gender;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->clinic_id = $request->clinic_id;
            if($request->image) {
                $file = $request->file('image');
                $tujuan_upload = 'public/img/medical-staff';
                if($file->move($tujuan_upload, time().'_'.$file->getClientOriginalName())) {
                    $data->image = 'public/img/medical-staff/'.time().'_'.$file->getClientOriginalName();
                };
            }
            $data->save();

            $data->syncClinics($request->clinics);
            
            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been updated")
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

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medical_staff',
            'name' => 'required|max:255',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medical_staff,code,'.$id,
            'name' => 'required|max:255',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
