<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Period;
use Carbon\Carbon;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Pharmacy;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MedicineController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medicine');
        $this->setModel('App\Models\Medicine');
    }

    public function index(Request $request)
    {
        try {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;

            if(method_exists($this->model, 'scopeWithAll')) {
                $query = $this->model::withAll();
            } else {
                $query = DB::table($this->getTableName());
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
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $in = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'In')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');
                    $transferIn = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer In')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $transferOut = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer Out')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $adj = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Adjusment')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $out = Pharmacy::join('pharmacy_details', 'pharmacy_details.pharmacy_id', '=', 'pharmacies.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('medicine_id', $dt->id)
                            ->sum('actual_qty');
                    
                    
                    $dt->setAttribute("stock", $begin+$in+$transferIn-$transferOut-$out+$adj);
                } else {
                    $in = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'In')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');
                    $transferIn = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer In')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $transferOut = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Transfer Out')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $adj = StockTransaction::join('stock_transaction_details', 'stock_transaction_details.stock_transaction_id', '=', 'stock_transactions.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('transaction_type', 'Adjusment')
                            ->where('medicine_id', $dt->id)
                            ->sum('qty');

                    $out = Pharmacy::join('pharmacy_details', 'pharmacy_details.pharmacy_id', '=', 'pharmacies.id')
                            ->where('clinic_id', $request->clinic_id ?? null)
                            ->whereDate('transaction_date','<=',Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->where('medicine_id', $dt->id)
                            ->sum('actual_qty');
                    
                    
                    $dt->setAttribute("stock", $in+$transferIn-$transferOut-$out+$adj);
                }
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

    public function stock(Request $request)
    {
        try {
            $clinicSql = \App\Models\Clinic::select("id");
            $clinicSql = $this->queryBuilder(['clinics'], $clinicSql);
            $clinicIds = $clinicSql->pluck("id")->toArray();
            $rawSql = "";
            foreach ($clinicIds ?? [] as $clinicId) {
                $prevPeriod = StockOpname::join('periods', 'periods.id', '=', 'stock_opnames.period_id')
                            ->where('stock_opnames.clinic_id', $clinicId)
                            ->where('start_date','<', Carbon::now()->isoFormat('YYYY-MM-DD'))
                            ->select('periods.*')
                            ->orderBy('start_date','desc')
                            ->first();

                if($rawSql) {
                    $rawSql .= " UNION ALL ";
                }
                if($prevPeriod) {
                    $rawSql .= "SELECT clinic_id, medicine_id, beginQty+inQty+trfInQty-trfOutQty-outQty+adjQty AS qty
                                FROM
                                (
                                    SELECT clinic_id, medicine_id, SUM(qty) AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_opnames WHERE clinic_id = ".$clinicId."  GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, SUM(qty) AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'In' AND clinic_id = ".$clinicId." AND transaction_date > '".$prevPeriod->end_date."' AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, SUM(qty) AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Transfer In' AND clinic_id = ".$clinicId." AND transaction_date > '".$prevPeriod->end_date."' AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, SUM(qty) AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Transfer Out' AND clinic_id = ".$clinicId." AND transaction_date > '".$prevPeriod->end_date."' AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, SUM(qty) AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Adjusment' AND clinic_id = ".$clinicId." AND transaction_date > '".$prevPeriod->end_date."' AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, SUM(qty) AS outQty, 0 AS adjQty  FROM pharmacies a JOIN pharmacy_details b ON a.id = b.pharmacy_id WHERE clinic_id = ".$clinicId." AND transaction_date > '".$prevPeriod->end_date."' AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                ) AS stock
                                HAVING qty != 0";
                } else {
                    $rawSql .= "SELECT clinic_id, medicine_id, beginQty+inQty+trfInQty-trfOutQty-outQty+adjQty AS qty
                                FROM
                                (
                                    SELECT clinic_id, medicine_id, SUM(qty) AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_opnames WHERE clinic_id = ".$clinicId."  GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, SUM(qty) AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'In' AND clinic_id = ".$clinicId." AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, SUM(qty) AS trfInQty, 0 AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Transfer In' AND clinic_id = ".$clinicId." AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, SUM(qty) AS trfOutQty, 0 AS outQty, 0 AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Transfer Out' AND clinic_id = ".$clinicId." AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, 0 AS outQty, SUM(qty) AS adjQty  FROM stock_transactions a JOIN stock_transaction_details b ON a.id = b.stock_transaction_id WHERE a.transaction_type = 'Adjusment' AND clinic_id = ".$clinicId." AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                    UNION ALL
                                    SELECT clinic_id, medicine_id, 0 AS beginQty, 0 AS inQty, 0 AS trfInQty, 0 AS trfOutQty, SUM(qty) AS outQty, 0 AS adjQty  FROM pharmacies a JOIN pharmacy_details b ON a.id = b.pharmacy_id WHERE clinic_id = ".$clinicId." AND transaction_date <= NOW() GROUP BY clinic_id, medicine_id
                                ) AS stock
                                HAVING qty != 0";
                }
                
            }

            $data = [];
            if($rawSql) {
                $data = DB::select($rawSql);
            }
            return response()->json([
                "status" => '200',
                "message" => '',
                "data" => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function filterBuilder(Request $request, $query)
    {
        $search = $request->input('search') ?? "";
        $columns = $request->input("column") ?? [];
        if($search && $columns) {
            $query->where(function($query) use ($search, $columns) 
            {
                foreach($columns as $column) {
                    $query->orWhere($column,'LIKE', "%{$search}%");
                }
            });    
        }

        foreach ($request->all() as $key => $value) {
            if($key == "sort" || $key == "page" || $key == "size" || $key == "search" || $key == "column" || $key == "query_builder"  || $key == "is_deleted" || $key == "is_sync" || $key == "clinic_id")
                continue;

            if($value != null) {            
                if(Str::endsWith($key, '_like')) {
                    $query->where(Str::replace('_like', '', $key),'LIKE',"%{$value}%");
                }
                else if(Str::endsWith($key, '_gt')) {
                    $query->where(Str::replace('_gt', '', $key),'>',$value);
                }
                else if(Str::endsWith($key, '_gte')) {
                    $query->where(Str::replace('_gte', '', $key),'>=',$value);
                }
                else if(Str::endsWith($key, '_lt')) {
                    $query->where(Str::replace('_lt', '', $key),'<',$value);
                }
                else if(Str::endsWith($key, '_lte')) {
                    $query->where(Str::replace('_lte', '', $key),'<=',$value);
                }
                else if(Str::endsWith($key, '_eq')) {
                    if($value == "null") {
                        $query->whereNull(Str::replace('_eq', '', $key));
                    } else {
                        $query->where(Str::replace('_eq', '', $key),'=',$value);
                    }
                }
                else if(Str::endsWith($key, '_neq')) {
                    if($value == "null") {
                        $query->whereNotNull(Str::replace('_neq', '', $key));
                    } else {
                        $query->where(Str::replace('_neq', '', $key),'<>',$value);
                    }
                }
                else if(Str::startsWith($value, '\\x') || Str::startsWith($value, '%') || Str::endsWith($value, '%')) {
                    $value = Str::replace('\\x', '%', $value);
                    $query->where($key,'LIKE', $value);
                } else {
                    if($value == "null") {
                        $query->whereNull($key);
                    } else {
                        $query->where($key,$value);
                    }
                }
            }
        }
        
        return $query;
    }
}
