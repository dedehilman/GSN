<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\PharmacyDetail;
use App\Models\Pharmacy;
use App\Models\Clinic;
use Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Action;

class PharmacyController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('pharmacy');
        $this->setModel('App\Models\Pharmacy');
    }

    
    public function store(Request $request)
    {
        try {
            $count = Pharmacy::whereDate('transaction_date', $request->transaction_date)->count();
            $request['transaction_no'] = 'PH-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'message'=> $validateOnStore,
                    'data' => '',
                ]);
            }

            DB::beginTransaction();
            $request["status"] = "Publish";
            $data = $this->model::create($request->all());
            if($request->details) {
                $ids = array();
                foreach ($request->details as $index => $detail)
                {
                    array_push($ids, $detail['id']);
                }
                PharmacyDetail::where('pharmacy_id', $data->id)
                            ->whereNotIn('id', $ids)->delete();
                            
                foreach ($request->details as $index => $detail)
                {
                    $pharmacyDetail = PharmacyDetail::where('pharmacy_id', $data->id)
                                        ->where('id', $detail['id'])->first();
                    if(!$pharmacyDetail)
                    {
                        $pharmacyDetail = new PharmacyDetail();
                        $pharmacyDetail->pharmacy_id = $data->id;
                    }

                    $pharmacyDetail->medicine_id = $detail['medicine_id'];
                    $pharmacyDetail->medicine_rule_id = $detail['medicine_rule_id'];
                    $pharmacyDetail->stock_qty = $detail['stock_qty'];
                    $pharmacyDetail->qty = $detail['qty'];
                    $pharmacyDetail->actual_qty = $detail['actual_qty'];
                    $pharmacyDetail->save();
                }
            } else {
                PharmacyDetail::where('pharmacy_id')->delete();
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
                'message'=> Lang::get("Data has been stored"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
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
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'message'=> $validateOnUpdate,
                    'data' => '',
                ]);
            }

            DB::beginTransaction();
            $request["status"] = "Publish";
            $data->fill($request->all())->save();
            if($request->details) {
                $ids = array();
                foreach ($request->details as $index => $detail)
                {
                    array_push($ids, $detail['id']);
                }
                PharmacyDetail::where('pharmacy_id', $data->id)
                            ->whereNotIn('id', $ids)->delete();

                foreach ($request->details as $index => $detail)
                {
                    $pharmacyDetail = PharmacyDetail::where('pharmacy_id', $data->id)
                                        ->where('id', $detail['id'])->first();
                    if(!$pharmacyDetail)
                    {
                        $pharmacyDetail = new PharmacyDetail();
                        $pharmacyDetail->pharmacy_id = $data->id;
                    }

                    $pharmacyDetail->medicine_id = $detail['medicine_id'];
                    $pharmacyDetail->medicine_rule_id = $detail['medicine_rule_id'];
                    $pharmacyDetail->stock_qty = $detail['stock_qty'];
                    $pharmacyDetail->qty = $detail['qty'];
                    $pharmacyDetail->actual_qty = $detail['actual_qty'];
                    $pharmacyDetail->save();
                    
                }
            } else {
                PharmacyDetail::where('pharmacy_id')->delete();
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
                'message'=> Lang::get("Data has been updated"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function unprocessed(Request $request)
    {
        try
        {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;

            $ids = Pharmacy::where('model_type', 'App\Models\FamilyPlanning')->pluck('model_id')->toArray();
            $q1 = DB::table('family_plannings')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'family_plannings.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\FamilyPlanning"'));
                    })
                    ->select('family_plannings.id','family_plannings.transaction_no','family_plannings.transaction_date','clinic_id','prescriptions.model_type')
                    ->whereNotIn('family_plannings.id', $ids)
                    ->distinct();
            $q1 = $this->queryBuilder(['family_plannings'], $q1);
            $q1 = $this->filterBuilder($request, $q1);

            $ids = Pharmacy::where('model_type', 'App\Models\Outpatient')->pluck('model_id')->toArray();
            $q2 = DB::table('outpatients')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'outpatients.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                    })
                    ->select('outpatients.id','outpatients.transaction_no','outpatients.transaction_date','clinic_id','prescriptions.model_type')
                    ->whereNotIn('outpatients.id', $ids)
                    ->distinct();
            $q2 = $this->queryBuilder(['outpatients'], $q2);
            $q2 = $this->filterBuilder($request, $q2);

            $ids = Pharmacy::where('model_type', 'App\Models\PlanoTest')->pluck('model_id')->toArray();
            $q3 = DB::table('plano_tests')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'plano_tests.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\PlanoTest"'));
                    })
                    ->select('plano_tests.id','plano_tests.transaction_no','plano_tests.transaction_date','clinic_id','prescriptions.model_type')
                    ->whereNotIn('plano_tests.id', $ids)
                    ->distinct();
            $q3 = $this->queryBuilder(['plano_tests'], $q3);
            $q3 = $this->filterBuilder($request, $q3);

            $ids = Pharmacy::where('model_type', 'App\Models\WorkAccident')->pluck('model_id')->toArray();
            $q4 = DB::table('work_accidents')
                    ->join('prescriptions', function ($join) {
                        $join->on('prescriptions.model_id', '=', 'work_accidents.id');
                        $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\WorkAccident"'));
                    })
                    ->select('work_accidents.id','work_accidents.transaction_no','work_accidents.transaction_date','clinic_id','prescriptions.model_type')
                    ->whereNotIn('work_accidents.id', $ids)
                    ->distinct();
            $q4 = $this->queryBuilder(['work_accidents'], $q4);
            $q4 = $this->filterBuilder($request, $q4);

            $query = $q1
                    ->union($q2)
                    ->union($q3)
                    ->union($q4);

            $totalData = $query->count();
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
                $dt->clinic = Clinic::find($dt->clinic_id);
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
            $dt->setAttribute("transaction", $dt->referenceTransaction());
        }
    }

    public function setToDraft($id) {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $data->status = "Draft";
            $data->save();
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
