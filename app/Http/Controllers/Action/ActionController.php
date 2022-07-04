<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Action;
use App\Models\Prescription;
use Illuminate\Support\Facades\DB;
use Lang;

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
        $action = Action::where('model_reference_type', get_class($data))
                    ->where('model_reference_id', $data->id)
                    ->first();

        if(!$action) {
            $action = new Action();
            $action->model_reference_type = get_class($data);
            $action->model_reference_id = $data->id;
        }

        $action->action = $request->action_action;
        $action->remark = $request->action_remark;
        if($action->action == 'Re-Medicate') {
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
            Prescription::where('model_reference_type', get_class($data))
                        ->where('model_reference_id', $data->id)
                        ->whereNotIn('id', $ids)->delete();

            for($i=0; $i<count($request->prescription_id); $i++)
            {
                $prescription = Prescription::where('model_reference_type', get_class($data))
                                    ->where('model_reference_id', $data->id)
                                    ->where('id', $request->prescription_id[$i])->first();
                if(!$prescription)
                {
                    $prescription = new Prescription();
                    $prescription->model_reference_type = get_class($data);
                    $prescription->model_reference_id = $data->id;
                }

                $prescription->medicine_id = $request->prescription_medicine_id[$i];
                $prescription->medicine_rule_id = $request->prescription_medicine_rule_id[$i];
                $prescription->qty = $request->prescription_qty[$i];
                $prescription->save();
            }    
        } else {
            Prescription::where('model_reference_type', get_class($data))
                        ->where('model_reference_id', $data->id)->delete();
        }
    }

    public function referenceLetter($id) {
        $data = $this->model::find($id);
        $action = Action::where('model_reference_type', get_class($data))
                    ->where('model_reference_id', $data->id)
                    ->first();
        return view("action.reference-letter", [
            "data" => $data,
            "action" => $action,
        ]);
    }

    public function sickLetter($id) {
        $data = $this->model::find($id);
        $action = Action::where('model_reference_type', get_class($data))
                    ->where('model_reference_id', $data->id)
                    ->first();
        return view("action.sick-letter", [
            "data" => $data,
            "action" => $action,
        ]);
    }

    public function storeReferenceLetter($id, Request $request) {
        
    }

    public function storeSickLetter($id, Request $request) {
        
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
                            $join->on('actions.model_reference_type', '=', DB::Raw("'".$this->getClassName()."'"));
                            $join->on('actions.model_reference_id', '=', $this->getTableName().".id");
                        })->select($this->getTableName().".*", 'actions.id AS action_id');
            } else {
                $query = DB::table($this->getTableName())
                        ->leftJoin('actions', function ($join) {
                            $join->on('actions.model_reference_type', '=', DB::Raw("'".$this->getClassName()."'"));
                            $join->on('actions.model_reference_id', '=', $this->getTableName().".id");
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
}

