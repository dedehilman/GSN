<?php

namespace App\Http\Controllers\Api\Action;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Action;
use App\Models\Prescription;
use App\Models\DiagnosisResult;
use Illuminate\Support\Facades\DB;
use Lang;
use App\Models\DiseaseMedicine;
use App\Models\Diagnosis;
use App\Models\Period;
use Carbon\Carbon;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Pharmacy;
use App\Models\MedicalStaff;
use App\Models\Clinic;
use App\Models\SickLetter;
use App\Models\ReferenceLetter;

class ActionController extends ApiController
{
    public function index(Request $request)
    {
        try {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;

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

            if($request->query_builder ?? "1" == "1") {
                $query = $this->queryBuilder([$this->getTableName()], $query);
            }
            $totalData = $query->count();
            $query = $this->filterBuilder($request, $query);
            $query = $this->sortBuilder($request, $query);
            $totalFiltered = $query->count();

            if ($size == -1) {
                $totalPage = 0;
                $data = $query->get();
            } else {
                $totalPage = ceil($totalFiltered / $size);
                if($totalPage > 0) {
                    $totalPage = $totalPage - 1;
                }
                $data = $query
                    ->offset($page * $size)
                    ->limit($size)
                    ->get();
            }
            
            foreach ($data as $dt) {
                $action = Action::where('model_id', $dt->id)->with('reference', 'referenceClinic')
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->first();

                $diagnoses = DiagnosisResult::where('model_id', $dt->id)->with('diagnosis','symptoms')
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->get();

                $prescriptions = Prescription::where('model_id', $dt->id)->with('medicine','medicineRule')
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->get();

                $medias = DB::table('media')->where('model_id', $dt->id)
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->get();

                $referenceLetter = ReferenceLetter::where('model_id', $dt->id)
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->first();

                $sickLetter = SickLetter::where('model_id', $dt->id)
                            ->where('model_type', DB::Raw("'".$this->getClassName()."'"))
                            ->first();
                
                $dt->setAttribute("action", $action);
                $dt->setAttribute("diagnoses", $diagnoses);
                $dt->setAttribute("prescriptions", $prescriptions);
                $dt->setAttribute("medias", $medias);
                $dt->setAttribute("medias", $medias);
                $dt->setAttribute("reference_letter", $referenceLetter);
                $dt->setAttribute("sick_letter", $sickLetter);
                $dt->setAttribute("pharmacy", $dt->pharmacy());
            }
            return response()->json([
                "status" => '200',
                "message" => '',
                "data" => array(
                    "page" => intval($page),
                    "size" => intval($size),
                    "total_page" => intval($totalPage),
                    "total_data" => intval($totalData),
                    "total_filtered" => intval($totalFiltered),
                    "data" => $data    
                )
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
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
            $data->fill($request->all())->save();
            $this->documentHandler($data, $request);
            $this->actionHandler($data, $request);
            $this->prescriptionHandler($data, $request);
            $this->diagnosisHandler($data, $request);

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => $data,
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
        if($request->medias) {
            $ids = array();
            foreach ($request->medias as $index => $media) {
                array_push($ids, $media['id']);
            }
            
            DB::table('media')->where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->whereNotIn('id', $ids)->delete();
        } else {
            $data->clearMediaCollection('media');
        }

        foreach ($request->medias ?? [] as $index => $media) {
            if($media['id'] != null && $media['id'] != 0) continue;

            $data->addMedia(storage_path('media/' . $media['file_name']))->toMediaCollection('media', 'media');;
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

        $action->action = $request->action['action'];
        $action->remark = $request->action['remark'];
        if($action->action == 'Remedicate') {
            $action->remedicate_date = $request->action['remedicate_date'];
        } else if ($action->action == 'Refer') {
            $action->reference_type = $request->action['reference_type'];
            if($action->reference_type == 'Internal') {
                $action->reference_clinic_id = $request->action['reference_clinic_id'];
            } else {
                $action->reference_id = $request->action['reference_id'];
            }
        }
        $action->save();
    }

    public function prescriptionHandler($data, Request $request) {
        if($request->prescriptions)
        {
            $ids = array();
            foreach ($request->prescriptions as $index => $prescription)
            {
                array_push($ids, $prescription['id']);
            }
            Prescription::where('model_type', get_class($data))
                        ->where('model_id', $data->id)
                        ->whereNotIn('id', $ids)->delete();

            foreach ($request->prescriptions as $index => $prescription)
            {
                $detail = Prescription::where('model_type', get_class($data))
                                    ->where('model_id', $data->id)
                                    ->where('id', $prescription['id'])->first();
                if(!$detail)
                {
                    $detail = new Prescription();
                    $detail->model_type = get_class($data);
                    $detail->model_id = $data->id;
                }

                $detail->medicine_id = $prescription['medicine_id'];
                $detail->medicine_rule_id = $prescription['medicine_rule_id'];
                $detail->stock_qty = $prescription['stock_qty'];
                $detail->qty = $prescription['qty'];
                $detail->save();
            }            
        } else {
            Prescription::where('model_type', get_class($data))
                        ->where('model_id', $data->id)->delete();
        }
    }

    public function diagnosisHandler($data, Request $request) {
        if($request->diagnoses)
        {
            $ids = array(); 
            foreach ($request->diagnoses as $index => $diagnosis) {
                array_push($ids, $diagnosis['id']);
            }
            DiagnosisResult::where('model_type', get_class($data))
                        ->where('model_id', $data->id)
                        ->whereNotIn('id', $ids)->delete();

            foreach ($request->diagnoses as $index => $diagnosis) {
                $detail = DiagnosisResult::where('model_type', get_class($data))
                                    ->where('model_id', $data->id)
                                    ->where('id', $diagnosis['id'])->first();
                if(!$detail)
                {
                    $detail = new DiagnosisResult();
                    $detail->model_type = get_class($data);
                    $detail->model_id = $data->id;
                }

                $detail->diagnosis_id = $diagnosis['diagnosis_id'];
                $detail->save();

                $ids = array(); 
                foreach ($diagnosis['symptoms'] ?? [] as $index => $symptom) {
                    array_push($ids, $symptom['id']);
                }
                $detail->syncSymptoms($ids);
            }
        } else {
            DiagnosisResult::where('model_type', get_class($data))
                        ->where('model_id', $data->id)->delete();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), []);

        if(!$request->action) {
            $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => Lang::get("Action")]));
        }

        if($request->prescriptions)
        {
            foreach ($request->prescriptions as $index => $prescription)
            {
                if(!$prescription['medicine_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Product")]));
                }
                if(!$prescription['medicine_rule_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Medicine Rule")]));
                }
                if(!$prescription['qty']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Qty")]));
                }
            }
        }

        if($request->diagnoses)
        {
            foreach ($request->diagnoses as $index => $diagnosis) {
                if(!$diagnosis['diagnosis_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Diagnosis")]));
                }
            }
        }

        return $validator->errors()->all();
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_no' => 'required|max:255',
            'transaction_date' => 'required',
            'clinic_id' => 'required',
            'patient_id' => 'required',
            'medical_staff_id' => 'required',
            'reference_type' => 'required',
        ]);

        if($request->reference_type == 'Internal') {
            $validator->addRules([
                'reference_clinic_id'=> 'required'
            ]);
        } else if($request->reference_type == 'External') {
            $validator->addRules([
                'reference_id'=> 'required',
            ]);
        }

        if($request->for_relationship == 1) {
            $validator->addRules([
                'patient_relationship_id'=> 'required'
            ]);
        }

        if(!$request->action) {
            $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => Lang::get("Action")]));
        }

        if($request->prescriptions)
        {
            foreach ($request->prescriptions as $index => $prescription)
            {
                if(!$prescription['medicine_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Product")]));
                }
                if(!$prescription['medicine_rule_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Medicine Rule")]));
                }
                if(!$prescription['qty']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Qty")]));
                }
            }
        }

        if($request->diagnoses)
        {
            foreach ($request->diagnoses as $index => $diagnosis) {
                if(!$diagnosis['diagnosis_id']) {
                    $validator->getMessageBag()->add('action', Lang::get('validation.required', ['attribute' => "[".($index+1)."] ".Lang::get("Diagnosis")]));
                }
            }
        }

        return $validator->errors()->all();
    }

    public function generatePrescription(Request $request) {
        try {
            $diseaseIds = Diagnosis::whereNotNull('disease_id')
                        ->whereIn('id', $request->diagnosis_id ?? [])
                        ->pluck('disease_id')
                        ->toArray();
            
            $data = DiseaseMedicine::whereIn('disease_id', $diseaseIds)->withAll()->get();

            $prevPeriod = StockOpname::join('periods', 'periods.id', '=', 'stock_opnames.period_id')
                    ->where('stock_opnames.clinic_id', $request->clinic_id ?? null)
                    ->where('start_date','<', Carbon::now()->isoFormat('YYYY-MM-DD'))
                    ->select('periods.*')
                    ->orderBy('start_date','desc')
                    ->first();
            foreach ($data as $dt) {
                $dt->setAttribute("stock_qty", '0.00');
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
                    
                    
                    $dt->setAttribute("stock_qty", $begin+$in+$transferIn-$transferOut-$out+$adj);
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

            $validateOnDestroy = $this->validateOnDestroy($id);
            if($validateOnDestroy) {
                return response()->json([
                    'status' => '400',
                    'message'=> $validateOnDestroy,
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

    public function setToDraft($id) {
        try {
            $data = $this->model::find($id);
            if(!$data || !$data->action()) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $action = $data->action();
            $action->status = "Draft";
            $action->save();
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been set to Draft"),
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

