<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Period;
use Carbon\Carbon;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Pharmacy;

class MedicineController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('medicine');
        $this->setDefaultView('master.medicine');
        $this->setSelect('master.medicine.select');
        $this->setModel('App\Models\Medicine');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicines',
            'name' => 'required|max:255',
            'medicine_type_id' => 'required',
            'unit_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:medicines,code,'.$id,
            'name' => 'required|max:255',
            'medicine_type_id' => 'required',
            'unit_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function selectStock(Request $request)
    {
        $parameters = array();
        foreach ($request->all() as $key => $value) {
            if($key == "_") continue;

            $parameters[$key] = $value;
        }
        $select = $request->select ?? 'single';
        return view('master.medicine.select-stock', compact('select', 'parameters'));
    }

    public function datatableSelectStock(Request $request)
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
                $query = $this->model::withAll();
            } else {
                $query = DB::table($this->getTableName());
            }
            if($request->parentId) {
                $query = $query->where(rtrim($this->getParentTableName(), "s")."_id", $request->parentId);
            }
            if(($request->parameters['queryBuilder'] ?? null) == null || $request->parameters['queryBuilder'] == '1') {
                $query = $this->queryBuilder([$this->getTableName()], $query);
            }            
            $this->setExtraParameterSelect($request);
            $query = $this->filterExtraParameterSelect($query);
            $totalData = $query->count();
            $query = $this->filterDatatableSelect($request, $query);
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

            $prevPeriod = StockOpname::join('periods', 'periods.id', '=', 'stock_opnames.period_id')
                    ->where('clinic_id', $request->clinic_id ?? null)
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
                }
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
