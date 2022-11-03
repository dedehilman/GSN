<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Traits\RuleQueryBuilderTrait;

class TransactionController extends AppCrudController
{
    use RuleQueryBuilderTrait;

    public function __construct()
    {
        $this->middleware('auth');
        $this->setSelect('transaction.select');
    }

    function datatableSelect(Request $request){
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
            
            $q1 = DB::table('family_plannings')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\FamilyPlanning" AS model_type'));
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q1 = $this->queryBuilder(['family_plannings'], $q1);
            }
            $q2 = DB::table('outpatients')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\Outpatient" AS model_type'));
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q2 = $this->queryBuilder(['outpatients'], $q2);
            }
            $q3 = DB::table('plano_tests')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\PlanoTest" AS model_type'));
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q3 = $this->queryBuilder(['plano_tests'], $q3);
            }
            $q4 = DB::table('work_accidents')
                    ->select('id','transaction_no','transaction_date','clinic_id',DB::Raw('"App\\\\Models\\\\WorkAccident" AS model_type'));
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $q4 = $this->queryBuilder(['work_accidents'], $q4);
            }

            $query = $q1
            ->union($q2)
            ->union($q3)
            ->union($q4);
            $querySql = $query->toSql();
            $query = DB::table(DB::raw("($querySql) as a"))->mergeBindings($query);

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
