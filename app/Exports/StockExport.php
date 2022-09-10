<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Medicine;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Models\Period;
use App\Models\Pharmacy;

class StockExport implements ShouldAutoSize, FromView
{
    use Exportable;

    private $reportModel;

    public function __construct($reportModel)
    {
        app()->setLocale(getCurrentUser()->appearance->language ?? 'id');
        $this->reportModel = $reportModel;
    }

    public function view(): View
    {
        $begin = array();
        $in = array();
        $transferIn = array();
        $transferOut = array();
        $out = array();
        $adj = array();

        $prevPeriod = Period::where('start_date','<',$this->reportModel->period->start_date)->orderBy('start_date','desc')->first();
        $medicines = Medicine::all();
        $stockOpnames = StockOpname::where('period_id', $prevPeriod->id)->where('clinic_id', $this->reportModel->period->clinic_id)->get();
        $stockTransactions = StockTransaction::where('clinic_id', $this->reportModel->period->clinic_id)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',$this->reportModel->period->end_date)->get();

        foreach ($stockOpnames as $stockOpname) {
            if(!array_key_exists($stockOpname->medicine->code, $begin)) {
                $begin[$stockOpname->medicine->code] = 0;
            }

            $begin[$stockOpname->medicine->code] = $begin[$stockOpname->medicine->code] + $stockOpname->qty;
        }

        foreach ($stockTransactions as $stockTransaction) {
            foreach ($stockTransaction->details as $detail) {
                if($stockTransaction->transaction_type == "In") {
                    if(!array_key_exists($detail->medicine->code, $in)) {
                        $in[$detail->medicine->code] = 0;
                    }
                    $in[$detail->medicine->code] = $in[$detail->medicine->code] + $detail->qty;    
                } else if($stockTransaction->transaction_type == "Transfer In") {
                    if(!array_key_exists($detail->medicine->code, $transferIn)) {
                        $transferIn[$detail->medicine->code] = 0;
                    }
                    $transferIn[$detail->medicine->code] = $transferIn[$detail->medicine->code] + $detail->qty;    
                } else if($stockTransaction->transaction_type == "Transfer Out") {
                    if(!array_key_exists($detail->medicine->code, $transferOut)) {
                        $transferOut[$detail->medicine->code] = 0;
                    }
                    $transferOut[$detail->medicine->code] = $transferOut[$detail->medicine->code] + $detail->qty;    
                } else if($stockTransaction->transaction_type == "Adjustment") {
                    if(!array_key_exists($detail->medicine->code, $adj)) {
                        $adj[$detail->medicine->code] = 0;
                    }
                    $adj[$detail->medicine->code] = $adj[$detail->medicine->code] + $detail->qty;    
                }
            }
        }

        $pharmacies = Pharmacy::where('clinic_id', $this->reportModel->period->clinic_id)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<=',$this->reportModel->period->end_date)->get();

        foreach ($pharmacies as $pharmacy) {
            foreach ($pharmacy->details as $detail) {
                if(!array_key_exists($detail->medicine->code, $out)) {
                    $out[$detail->medicine->code] = 0;
                }
                $out[$detail->medicine->code] = $out[$detail->medicine->code] + $detail->actual_qty;
            }
        }
        return view('report.stock.template', [
            "reportModel"=> $this->reportModel,
            "medicines"=> $medicines,
            "begin"=> $begin,
            "in"=> $in,
            "transferIn"=> $transferIn,
            "transferOut"=> $transferOut,
            "out"=> $out,
            "adj"=> $adj,
        ]);
    }
}
