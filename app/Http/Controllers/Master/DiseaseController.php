<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Disease;
use App\Models\DiseaseMedicine;
use Illuminate\Support\Facades\DB;
use Lang;

class DiseaseController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('disease');
        $this->setSelect('master.disease.select');
        $this->setIndex('master.disease.index');
        $this->setCreate('master.disease.create');
        $this->setEdit('master.disease.edit');
        $this->setView('master.disease.view');
        $this->setModel('App\Models\Disease');
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
            $data = new Disease();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->disease_group_id = $request->disease_group_id;
            $data->save();

            if($request->disease_medicine_id)
            {
                $ids = array_filter($request->disease_medicine_id); 
                DiseaseMedicine::where('disease_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->disease_medicine_id); $i++)
                {
                    $detail = DiseaseMedicine::where('disease_id', $data->id)->where('id', $request->disease_medicine_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new DiseaseMedicine();
                    }

                    $detail->disease_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->medicine_rule_id = $request->medicine_rule_id[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->save();
                }    
            } else {
                DiseaseMedicine::where('disease_id', $data->id)->delete();
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
            $data->disease_group_id = $request->disease_group_id;
            $data->save();

            if($request->disease_medicine_id)
            {
                $ids = array_filter($request->disease_medicine_id); 
                DiseaseMedicine::where('disease_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->disease_medicine_id); $i++)
                {
                    $detail = DiseaseMedicine::where('disease_id', $data->id)->where('id', $request->disease_medicine_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new DiseaseMedicine();
                    }

                    $detail->disease_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->medicine_rule_id = $request->medicine_rule_id[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->save();
                }    
            } else {
                DiseaseMedicine::where('disease_id', $data->id)->delete();
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
            'code' => 'required|max:255|unique:diseases',
            'name' => 'required|max:255',
            'disease_group_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:diseases,code,'.$id,
            'name' => 'required|max:255',
            'disease_group_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}

