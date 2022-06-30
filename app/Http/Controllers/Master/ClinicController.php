<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Clinic;
use Illuminate\Support\Facades\DB;
use Lang;

class ClinicController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('clinic');
        $this->setSelect('master.clinic.select');
        $this->setIndex('master.clinic.index');
        $this->setCreate('master.clinic.create');
        $this->setEdit('master.clinic.edit');
        $this->setView('master.clinic.view');
        $this->setModel('App\Models\Clinic');
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
            $data = new Clinic();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->location = $request->location;
            $data->phone = $request->phone;
            $data->estate_id = $request->estate_id;
            
            if($request->image) {
                $file = $request->file('image');
                $tujuan_upload = 'public/img/clinic';
                if($file->move($tujuan_upload, time().'_'.$file->getClientOriginalName())) {
                    $data->image = 'public/img/clinic/'.time().'_'.$file->getClientOriginalName();
                };
            }

            $data->save();
            
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
            $data->address = $request->address;
            $data->location = $request->location;
            $data->phone = $request->phone;
            $data->estate_id = $request->estate_id;
            
            if($request->image) {
                $file = $request->file('image');
                $tujuan_upload = 'public/img/clinic';
                if($file->move($tujuan_upload, time().'_'.$file->getClientOriginalName())) {
                    $data->image = 'public/img/clinic/'.time().'_'.$file->getClientOriginalName();
                };
            }

            $data->save();

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
            'code' => 'required|max:255|unique:clinics',
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:clinics,code,'.$id,
            'name' => 'required|max:255',
            'estate_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

