<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
use App\Models\Clinic;

class TransactionController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    function index(Request $request){
        try
        {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;
            
            $q1 = DB::table('family_plannings')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\FamilyPlanning" AS model_type'));
            if($request->query_builder ?? "1" == "1") {
                $q1 = $this->queryBuilder(['family_plannings'], $q1);
            }
            $q2 = DB::table('outpatients')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\Outpatient" AS model_type'));
            if($request->query_builder ?? "1" == "1") {
                $q2 = $this->queryBuilder(['outpatients'], $q2);
            }
            $q3 = DB::table('plano_tests')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\PlanoTest" AS model_type'));
            if($request->query_builder ?? "1" == "1") {
                $q3 = $this->queryBuilder(['plano_tests'], $q3);
            }
            $q4 = DB::table('work_accidents')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\WorkAccident" AS model_type'));
            if($request->query_builder ?? "1" == "1") {
                $q4 = $this->queryBuilder(['work_accidents'], $q4);
            }

            $query = $q1
            ->union($q2)
            ->union($q3)
            ->union($q4);
            $querySql = $query->toSql();
            $query = DB::table(DB::raw("($querySql) as a"))->mergeBindings($query);

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
}
