<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Period;
use App\Models\StockOpnameTmp;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Pharmacy;
use Carbon\Carbon;

class PeriodController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('period');
        $this->setDefaultView('master.period');
        $this->setSelect('master.period.select');
        $this->setModel('App\Models\Period');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:periods',
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:periods,code,'.$id,
            'name' => 'required|max:255',
            'start_date' => 'required',
            'end_date' => 'required',
            'clinic_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function filterDatatable(Request $request, $query)
    {
        if(isset($request->parameters['start_date']) && isset($request->parameters['end_date'])) {
            $startDate = $request->parameters['start_date'];
            $endDate = $request->parameters['end_date'];
            $query->where(function($query) use($startDate, $endDate)
            {
                $query->whereRaw('? between start_date and end_date', $startDate);
                $query->orWhereRaw('? between start_date and end_date', $endDate);
            });
        } else if(isset($request->parameters['start_date'])) {
            $query->whereRaw('? between start_date and end_date', $request->parameters['start_date']);
        } else if(isset($request->parameters['end_date'])) {
            $query->whereRaw('? between start_date and end_date', $request->parameters['end_date']);
        }

        if(isset($request->parameters['clinic_id'])) {
            $query->where('clinic_id', $request->parameters['clinic_id']);
        }

        return $query;
    }

    public function stockTaking($id) {
        try {
            $stock = array();
            $period = Period::find($id);
            $prevPeriod = Period::where('start_date','<',$period->start_date)->orderBy('start_date','desc')->first();
            $stockOpnames = StockOpname::where('period_id', $prevPeriod->id)->where('clinic_id', $period->clinic_id)->get();
            $stockTransactions = StockTransaction::where('clinic_id', $period->clinic_id)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',$period->end_date)->get();
            $pharmacies = Pharmacy::where('clinic_id', $period->clinic_id)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',$period->end_date)->get();

            foreach ($stockOpnames as $stockOpname) {
                if(!array_key_exists($stockOpname->medicine_id, $stock)) {
                    $stock[$stockOpname->medicine_id] = 0;
                }
    
                $stock[$stockOpname->medicine_id] = $stock[$stockOpname->medicine_id] + $stockOpname->qty;
            }

            foreach ($stockTransactions as $stockTransaction) {
                foreach ($stockTransaction->details as $detail) {
                    if($stockTransaction->transaction_type == "In") {
                        if(!array_key_exists($detail->medicine_id, $stock)) {
                            $stock[$detail->medicine_id] = 0;
                        }
                        $stock[$detail->medicine_id] = $stock[$detail->medicine_id] + $detail->qty;    
                        
                    } else if($stockTransaction->transaction_type == "Transfer In") {
                        if(!array_key_exists($detail->medicine_id, $stock)) {
                            $stock[$detail->medicine_id] = 0;
                        }
                        $stock[$detail->medicine_id] = $stock[$detail->medicine_id] + $detail->qty;    
                    } else if($stockTransaction->transaction_type == "Transfer Out") {
                        if(!array_key_exists($detail->medicine_id, $stock)) {
                            $stock[$detail->medicine_id] = 0;
                        }
                        $stock[$detail->medicine_id] = $stock[$detail->medicine_id] - $detail->qty;    
                    } else if($stockTransaction->transaction_type == "Adjustment") {
                        if(!array_key_exists($detail->medicine_id, $stock)) {
                            $stock[$detail->medicine_id] = 0;
                        }
                        $stock[$detail->medicine_id] = $stock[$detail->medicine_id] + $detail->qty;    
                    }
                }
            }

            foreach ($pharmacies as $pharmacy) {
                foreach ($pharmacy->details as $detail) {
                    if(!array_key_exists($detail->medicine_id, $stock)) {
                        $stock[$detail->medicine_id] = 0;
                    }
                    $stock[$detail->medicine_id] = $stock[$detail->medicine_id] - $detail->actual_qty;
                }
            }

            StockOpnameTmp::where('period_id', $period->id)->where('clinic_id', $period->clinic_id)->delete();
            foreach ($stock as $key => $value) {
                $data = new StockOpnameTmp();
                $data->clinic_id = $period->clinic_id;
                $data->period_id = $period->id;
                $data->medicine_id = $key;
                $data->qty = $value;

                $data->save();
            }

            $data = StockOpnameTmp::where('period_id', $period->id)->where('clinic_id', $period->clinic_id)->get();

            return view('master.period.stock-taking', [
                'period'=> $period,
                'data'=> $data
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['info' => $th->getMessage()]);
        }
    }

    public function stockTakingSave($id) {
        try {
            $period = Period::find($id);
            $period->closed_date = Carbon::now()->isoFormat('YYYYMMDD');
            $period->save();

            StockOpname::where('period_id', $period->id)->where('clinic_id', $period->clinic_id)->delete();
            $dataTmp = StockOpnameTmp::where('period_id', $period->id)->where('clinic_id', $period->clinic_id)->get();
            foreach ($dataTmp as $dt) {
                $data = new StockOpname();
                $data->clinic_id = $period->clinic_id;
                $data->period_id = $period->id;
                $data->medicine_id = $dt->medicine_id;
                $data->qty = $dt->qty;

                $data->save();
            }

            return view('master.period.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with(['info' => $th->getMessage()]);
        }
    }
}
