<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Action;
use App\Models\Prescription;
use App\Models\DiagnosisResult;
use App\Models\DiagnosisSymptomResult;
use Illuminate\Support\Facades\DB;
use Lang;
use App\Models\DiseaseMedicine;
use App\Models\Diagnosis;
use App\Models\Period;
use Carbon\Carbon;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Pharmacy;

class ActionController extends AppCrudController
{
    public function update(Request $request, $id)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
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
            $data->fill($request->all())->save();
            $this->documentHandler($data, $request);
            $this->actionHandler($data, $request);
            $this->prescriptionHandler($data, $request);
            $this->diagnosisHandler($data, $request);

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

    public function documentHandler($data, Request $request) {
        if($request->media_id) {
            $ids = array_filter($request->media_id); 
            DB::table('media')->where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->whereNotIn('id', $ids)->delete();
        } else {
            $data->clearMediaCollection('media');
        }

        foreach ($request->input('document', []) as $file) {
            $data->addMedia(storage_path('media/' . $file))->toMediaCollection('media', 'media');;
        }
    }

    public function actionHandler($data, Request $request) {
        $action = Action::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();

        if(!$action) {
            $action = new Action();
            $action->model_type = get_class($data);
            $action->model_id = $data->id;
        }

        $action->action = $request->action_action;
        $action->remark = $request->action_remark;
        if($action->action == 'Remedicate') {
            $action->remedicate_date = $request->action_remedicate_date;
        } else if ($action->action == 'Refer') {
            $action->reference_type = $request->action_reference_type;
            if($action->reference_type == 'Internal') {
                $action->reference_clinic_id = $request->action_reference_clinic_id;
            } else {
                $action->reference_id = $request->action_reference_id;
            }
        }
        $action->save();
    }

    public function prescriptionHandler($data, Request $request) {
        if($request->prescription_id)
        {
            $ids = array_filter($request->prescription_id); 
            Prescription::where('model_type', get_class($data))
                        ->where('model_id', $data->id)
                        ->whereNotIn('id', $ids)->delete();

            for($i=0; $i<count($request->prescription_id); $i++)
            {
                $prescription = Prescription::where('model_type', get_class($data))
                                    ->where('model_id', $data->id)
                                    ->where('id', $request->prescription_id[$i])->first();
                if(!$prescription)
                {
                    $prescription = new Prescription();
                    $prescription->model_type = get_class($data);
                    $prescription->model_id = $data->id;
                }

                $prescription->medicine_id = $request->prescription_medicine_id[$i];
                $prescription->medicine_rule_id = $request->prescription_medicine_rule_id[$i];
                $prescription->stock_qty = $request->prescription_stock_qty[$i];
                $prescription->qty = $request->prescription_qty[$i];
                $prescription->save();
            }    
        } else {
            Prescription::where('model_type', get_class($data))
                        ->where('model_id', $data->id)->delete();
        }
    }

    public function diagnosisHandler($data, Request $request) {
        if($request->diagnosis_result_id)
        {
            $ids = array_filter($request->diagnosis_result_id); 
            DiagnosisResult::where('model_type', get_class($data))
                        ->where('model_id', $data->id)
                        ->whereNotIn('id', $ids)->delete();

            for($i=0; $i<count($request->diagnosis_result_id); $i++)
            {
                $diagnosis = DiagnosisResult::where('model_type', get_class($data))
                                    ->where('model_id', $data->id)
                                    ->where('id', $request->diagnosis_result_id[$i])->first();
                if(!$diagnosis)
                {
                    $diagnosis = new DiagnosisResult();
                    $diagnosis->model_type = get_class($data);
                    $diagnosis->model_id = $data->id;
                }

                $diagnosis->diagnosis_id = $request->diagnosis_result_diagnosis_id[$i];
                $diagnosis->save();
                $diagnosis->syncSymptoms($request->input('diagnosis_symptom_id'.$request->diagnosis_result_id[$i]));
            }    
        } else {
            DiagnosisResult::where('model_type', get_class($data))
                        ->where('model_id', $data->id)->delete();
        }
    }

    public function datatable(Request $request)
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
            
            if(method_exists($this->model, 'scopeWithAll')) {
                $query = $this->model::withAll()
                        ->leftJoin('actions', function ($join) {
                            $join->on('actions.model_type', '=', DB::Raw("'".$this->getClassName()."'"));
                            $join->on('actions.model_id', '=', $this->getTableName().".id");
                        })->select($this->getTableName().".*", 'actions.id AS action_id');
            } else {
                $query = DB::table($this->getTableName())
                        ->leftJoin('actions', function ($join) {
                            $join->on('actions.model_type', '=', DB::Raw("'".$this->getClassName()."'"));
                            $join->on('actions.model_id', '=', $this->getTableName().".id");
                        })->select($this->getTableName().".*", 'actions.id AS action_id');
            }
            if($request->parentId) {
                $query = $query->where(rtrim($this->getParentTableName(), "s")."_id", $request->parentId);
            }
            if(!$request->queryBuilder || $request->queryBuilder == '1') {
                $query = $this->queryBuilder([$this->getTableName()], $query);
            }
            $this->setExtraParameter($request);
            $query = $this->filterExtraParameter($query);
            $totalData = $query->count();
            $query = $this->filterDatatable($request, $query);
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

    public function generatePrescription(Request $request) {
        try {
            $diseaseIds = Diagnosis::whereNotNull('disease_id')
                        ->whereIn('id', $request->diagnosis_id ?? [])
                        ->pluck('id')
                        ->toArray();
            
            $data = DiseaseMedicine::whereIn('disease_id', $diseaseIds)->withAll()->get();

            $prevPeriod = StockOpname::join('periods', 'periods.id', '=', 'stock_opnames.period_id')
                    ->where('stock_opnames.clinic_id', $request->clinic_id ?? null)
                    ->where('start_date','<', Carbon::now()->isoFormat('YYYY-MM-DD'))
                    ->select('periods.*')
                    ->orderBy('start_date','desc')
                    ->first();
            foreach ($data as $dt) {
                $dt->setAttribute("stock", '0.00');
                if($prevPeriod) {
                    $begin = StockOpname::where('period_id', $prevPeriod->id)
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('qty');

                    $in = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'In')
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('qty');
                    $transferIn = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer In')
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('qty');

                    $transferOut = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer Out')
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('qty');

                    $adj = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Adjusment')
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('qty');

                    $out = Pharmacy::join('pharmacy_details', 'pharmacy_details.pharmacy_id', '=', 'pharmacies.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('medicine_id', $dt->medicine_id)
                            ->sum('actual_qty');
                    
                    
                    $dt->setAttribute("stock", $begin+$in+$transferIn-$transferOut-$out+$adj);
                }
            }
            return response()->json([
                'status' => '200',
                'data' => $data,
                'message' => ''
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), []);

        if(!$request->action_action) {
            $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => Lang::get("Action")]));
        }

        if($request->prescription_id)
        {
            for($i=0; $i<count($request->prescription_id); $i++)
            {
                if(!$request->prescription_medicine_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Product")]));
                }
                if(!$request->prescription_medicine_rule_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Medicine Rule")]));
                }
                if(!$request->prescription_qty[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Qty")]));
                }
            }    
        }

        if($request->diagnosis_result_id)
        {
            for($i=0; $i<count($request->diagnosis_result_id); $i++)
            {
                if(!$request->diagnosis_result_diagnosis_id[$i]) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($i+1)."] ".Lang::get("Diagnosis")]));
                }
            }    
        }

        return $validator->errors()->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $data->clearMediaCollection('media');
            Prescription::where('model_type', get_class($data))->where('model_id', $data->id)->delete();
            Action::where('model_type', get_class($data))->where('model_id', $data->id)->delete();
            DiagnosisResult::where('model_type', get_class($data))->where('model_id', $data->id)->delete();
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been deleted"),
                'data' => $data,
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

