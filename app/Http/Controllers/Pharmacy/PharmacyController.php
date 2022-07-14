<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Models\Prescription;
use App\Models\Outpatient;
use App\Models\FamilyPlanning;
use App\Models\WorkAccident;
use App\Models\PlanoTest;
use Illuminate\Support\Facades\DB;
use Lang;
use Carbon\Carbon;

class PharmacyController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('pharmacy');
        $this->setDefaultView('pharmacy');
        $this->setModel('App\Models\Pharmacy');
    }

    public function create(Request $request)
    {
        if($request->parentId) {
            $data = $this->parentModel::find($request->parentId);
            if(!$data) {
                return redirect()->back()->with(['info' => Lang::get("Data not found")]);
            }

            return view($this->create, compact('data'));    
        }

        $prescriptions = null;
        $dataRef = null;
        if($request->model_id && $request->model_type) {
            $prescriptions = Prescription::where('model_id', $request->model_id)
                    ->where('model_type', $request->model_type)
                    ->get();
            
            if($request->model_type == 'App\Models\Outpatient') {
                $dataRef = Outpatient::find($request->model_id);
            }
            else if($request->model_type == 'App\Models\FamilyPlanning') {
                $dataRef = FamilyPlanning::find($request->model_id);
            }
            else if($request->model_type == 'App\Models\PlanoTest') {
                $dataRef = PlanoTest::find($request->model_id);
            }
            else if($request->model_type == 'App\Models\WorkAccident') {
                $dataRef = WorkAccident::find($request->model_id);
            }
        }

        return view($this->create, [
            "prescriptions" => $prescriptions,
            "dataRef" => $dataRef,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $count = Pharmacy::whereDate('transaction_date', Carbon::parse($request->transaction_date)->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'PH-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }

            DB::beginTransaction();
            $data = new Pharmacy();
            $data->model_id = $request->model_id;
            $data->model_type = $request->model_type;
            $data->transaction_no = $request->transaction_no;
            $data->transaction_date = $request->transaction_date;
            $data->remark = $request->remark;
            $data->clinic_id = $request->clinic_id;
            $data->save();

            if($request->pharmacy_detail_id)
            {
                $ids = array_filter($request->pharmacy_detail_id); 
                PharmacyDetail::where('pharmacy_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->pharmacy_detail_id); $i++)
                {
                    $detail = PharmacyDetail::where('pharmacy_id', $data->id)->where('id', $request->pharmacy_detail_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new PharmacyDetail();
                    }

                    $detail->pharmacy_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->medicine_rule_id = $request->medicine_rule_id[$i];
                    $detail->stock_qty = $request->stock_qty[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->actual_qty = $request->actual_qty[$i];
                    $detail->save();
                }    
            } else {
                PharmacyDetail::where('pharmacy_id', $data->id)->delete();
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
            $data->transaction_no = $request->transaction_no;
            $data->transaction_date = $request->transaction_date;
            $data->remark = $request->remark;
            $data->clinic_id = $request->clinic_id;
            $data->save();

            if($request->pharmacy_detail_id)
            {
                $ids = array_filter($request->pharmacy_detail_id); 
                PharmacyDetail::where('pharmacy_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->pharmacy_detail_id); $i++)
                {
                    $detail = PharmacyDetail::where('pharmacy_id', $data->id)->where('id', $request->pharmacy_detail_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new PharmacyDetail();
                    }

                    $detail->pharmacy_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->medicine_rule_id = $request->medicine_rule_id[$i];
                    $detail->stock_qty = $request->stock_qty[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->actual_qty = $request->actual_qty[$i];
                    $detail->save();
                }    
            } else {
                PharmacyDetail::where('pharmacy_id', $data->id)->delete();
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
            'transaction_date' => 'required',
            'transaction_no' => 'required',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required',
            'transaction_no' => 'required',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function datatableUnprocessed(Request $request)
    {
        try
        {
            $q1 = DB::table('family_plannings')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'family_plannings.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\FamilyPlanning"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'family_plannings.clinic_id')
                    ->select('family_plannings.transaction_no','family_plannings.transaction_date','clinics.name AS clinic_name')
                    ->distinct();
            $q1 = $this->queryBuilder(['family_plannings'], $q1);

            $q2 = DB::table('outpatients')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'outpatients.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'outpatients.clinic_id')
                    ->select('outpatients.transaction_no','outpatients.transaction_date','clinics.name AS clinic_name')
                    ->distinct();
            $q2 = $this->queryBuilder(['outpatients'], $q2);

            $q3 = DB::table('plano_tests')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'plano_tests.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\PlanoTest"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'plano_tests.clinic_id')
                    ->select('plano_tests.transaction_no','plano_tests.transaction_date','clinics.name AS clinic_name')
                    ->distinct();
            $q3 = $this->queryBuilder(['plano_tests'], $q3);

            $q4 = DB::table('work_accidents')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'work_accidents.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\WorkAccident"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'work_accidents.clinic_id')
                    ->select('work_accidents.transaction_no','work_accidents.transaction_date','clinics.name AS clinic_name')
                    ->distinct();
            $q4 = $this->queryBuilder(['work_accidents'], $q4);

            $data = $q1
                    ->union($q2)
                    ->union($q3)
                    ->union($q4)
                    ->get();

            $totalData = count($data);
            $totalFiltered = $totalData;

            return response()->json([
                "draw" => intval($request->input('draw')),  
                "recordsTotal" => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data" => $data
            ]);
        } 
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }
}
