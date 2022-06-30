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
        $this->middleware('auth');
        $this->setSelect('master.medical-staff.select');
        $this->setIndex('master.medical-staff.index');
        $this->setCreate('master.medical-staff.create');
        $this->setEdit('master.medical-staff.edit');
        $this->setView('master.medical-staff.view');
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
            $data->save();

            if($request->medical_staff_clinic_id)
            {
                $ids = array_filter($request->medical_staff_clinic_id); 
                MedicalStaffClinic::where('medical_staff_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->medical_staff_clinic_id); $i++)
                {
                    $detail = MedicalStaffClinic::where('medical_staff_id', $data->id)->where('id', $request->medical_staff_clinic_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new MedicalStaffClinic();
                    }

                    $detail->medical_staff_id = $data->id;
                    $detail->clinic_id = $request->clinic_id[$i];
                    $detail->effective_date = $request->effective_date[$i];
                    $detail->expiry_date = $request->expiry_date[$i];
                    $detail->save();
                }    
            } else {
                MedicalStaffClinic::where('medical_staff_id', $data->id)->delete();
            }

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
            $data->save();

            if($request->medical_staff_clinic_id)
            {
                $ids = array_filter($request->medical_staff_clinic_id); 
                MedicalStaffClinic::where('medical_staff_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->medical_staff_clinic_id); $i++)
                {
                    $detail = MedicalStaffClinic::where('medical_staff_id', $data->id)->where('id', $request->medical_staff_clinic_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new MedicalStaffClinic();
                    }

                    $detail->medical_staff_id = $data->id;
                    $detail->clinic_id = $request->clinic_id[$i];
                    $detail->effective_date = $request->effective_date[$i];
                    $detail->expiry_date = $request->expiry_date[$i];
                    $detail->save();
                }    
            } else {
                MedicalStaffClinic::where('medical_staff_id', $data->id)->delete();
            }

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
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
