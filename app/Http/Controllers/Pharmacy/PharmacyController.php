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
use App\Models\Action;
use Illuminate\Support\Facades\DB;
use Lang;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

    public function edit(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        if($data->status == "Publish") {
            if(Str::contains($request->path(), '/edit')) {
                return redirect(route('pharmacy.show', $data->id));
            }
        }
        return view($this->edit, compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $transactionNo = Pharmacy::where('transaction_no', 'LIKE', 'PH-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-%')->orderBy('transaction_no', 'desc')->first();
			$count = 0;
			try {
				$count = (int) Str::substr($transactionNo->transaction_no, -5);				
			} catch (\Throwable $th) {
			}
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
            $data->status = "Publish";
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

            if($data->model_type) {
                $action = Action::where("model_type", $data->model_type)->where('model_id', $data->model_id)->first();
                if($action) {
                    $action->status = "Publish";
                    $action->save();    
                }

                $registration = $data->model_type::find($data->model_id);
                if($registration) {
                    $registration->status = "Publish";
                    $registration->save();    
                }
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
            $data->status = "Publish";
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

            if($data->model_type) {
                $action = Action::where("model_type", $data->model_type)->where('model_id', $data->model_id)->first();
                if($action) {
                    $action->status = "Publish";
                    $action->save();    
                }

                $registration = $data->model_type::find($data->model_id);
                if($registration) {
                    $registration->status = "Publish";
                    $registration->save();    
                }
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

        if($request->pharmacy_detail_id)
        {
            for($i=0; $i<count($request->pharmacy_detail_id); $i++)
            {
                if(!$request->medicine_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Product")]));
                }
                if(!$request->medicine_rule_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Medicine Rule")]));
                }
                if(!$request->actual_qty[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Actual Qty")]));
                }
            }    
        }

        return $validator->errors()->all();
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required',
            'transaction_no' => 'required',
            'clinic_id' => 'required',
        ]);

        if($request->pharmacy_detail_id)
        {
            for($i=0; $i<count($request->pharmacy_detail_id); $i++)
            {
                if(!$request->medicine_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Product")]));
                }
                if(!$request->medicine_rule_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Medicine Rule")]));
                }
                if(!$request->actual_qty[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Actual Qty")]));
                }
            }    
        }

        return $validator->errors()->all();
    }

    public function datatableUnprocessed(Request $request)
    {
        try
        {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $order = "id";
            if($request->input('order.0.column') < count($this->columnSelect)) {
                $order = $this->columnSelect[$request->input('order.0.column')];
            } else if($request->input('columns.'.$request->input('order.0.column').'.name')) {
                $order = $request->input('columns.'.$request->input('order.0.column').'.name');
            }
            $dir = 'asc';
            if($request->input('order.0.dir')) {
                $dir = $request->input('order.0.dir');
            }

            $ids = Pharmacy::where('model_type', 'App\Models\FamilyPlanning')->pluck('model_id')->toArray();
            $q1 = DB::table('family_plannings')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'family_plannings.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\FamilyPlanning"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'family_plannings.clinic_id')
                    ->join('employees', 'employees.id', '=', 'family_plannings.patient_id')
                    ->select('family_plannings.id','family_plannings.transaction_no','family_plannings.transaction_date','clinics.name AS clinic_name','prescriptions.model_type','clinics.id AS clinic_id','employees.name AS patient_name','employees.id AS patient_id')
                    ->whereNotIn('family_plannings.id', $ids)
                    ->distinct();
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q1 = $this->queryBuilder(['family_plannings'], $q1);
            }
            $q1 = $this->filterDatatable($request, $q1);

            $ids = Pharmacy::where('model_type', 'App\Models\Outpatient')->pluck('model_id')->toArray();
            $q2 = DB::table('outpatients')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'outpatients.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'outpatients.clinic_id')
                    ->join('employees', 'employees.id', '=', 'outpatients.patient_id')
                    ->select('outpatients.id','outpatients.transaction_no','outpatients.transaction_date','clinics.name AS clinic_name','prescriptions.model_type','clinics.id AS clinic_id','employees.name AS patient_name','employees.id AS patient_id')
                    ->whereNotIn('outpatients.id', $ids)
                    ->distinct();
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q2 = $this->queryBuilder(['outpatients'], $q2);
            }
            $q2 = $this->filterDatatable($request, $q2);

            $ids = Pharmacy::where('model_type', 'App\Models\PlanoTest')->pluck('model_id')->toArray();
            $q3 = DB::table('plano_tests')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'plano_tests.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\PlanoTest"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'plano_tests.clinic_id')
                    ->join('employees', 'employees.id', '=', 'plano_tests.patient_id')
                    ->select('plano_tests.id','plano_tests.transaction_no','plano_tests.transaction_date','clinics.name AS clinic_name','prescriptions.model_type','clinics.id AS clinic_id','employees.name AS patient_name','employees.id AS patient_id')
                    ->whereNotIn('plano_tests.id', $ids)
                    ->distinct();
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q3 = $this->queryBuilder(['plano_tests'], $q3);
            }
            $q3 = $this->filterDatatable($request, $q3);

            $ids = Pharmacy::where('model_type', 'App\Models\WorkAccident')->pluck('model_id')->toArray();
            $q4 = DB::table('work_accidents')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'work_accidents.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\WorkAccident"'));
                    })
                    ->join('clinics', 'clinics.id', '=', 'work_accidents.clinic_id')
                    ->join('employees', 'employees.id', '=', 'work_accidents.patient_id')
                    ->select('work_accidents.id','work_accidents.transaction_no','work_accidents.transaction_date','clinics.name AS clinic_name','prescriptions.model_type','clinics.id AS clinic_id','employees.name AS patient_name','employees.id AS patient_id')
                    ->whereNotIn('work_accidents.id', $ids)
                    ->distinct();
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q4 = $this->queryBuilder(['work_accidents'], $q4);
            }
            $q4 = $this->filterDatatable($request, $q4);

            $query = $q1
            ->union($q2)
            ->union($q3)
            ->union($q4);
            $querySql = $query->toSql();
            $query = DB::table(DB::raw("($querySql) as a"))->mergeBindings($query);

            $this->setExtraParameter($request);
            $query = $this->filterExtraParameter($query);
            $totalData = $query->count();
            $totalFiltered = $query->count();

            if ($length == -1) {
                $data = $query
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $data = $query
                    ->offset($start)
                    ->limit($length)
                    ->orderBy($order, $dir)
                    ->get();
            }
            
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

    public function addExtraAttribute($data) {
        foreach ($data as $dt) {
            $dt->setAttribute("referenceTransaction", $dt->referenceTransaction());
        }
    }

    public function setToDraft($id) {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $data->status = "Draft";
        $data->save();
        return redirect()->back()->with(['success' => Lang::get("Data has been set to Draft")]);
    }
}
