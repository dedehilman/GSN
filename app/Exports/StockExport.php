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
use App\Models\Clinic;
use Carbon\Carbon;

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
        $transferOutClinic = array();
        $out = array();
        $adj = array();
        $outDate = array();

        $medicines = Medicine::all();
        $prevPeriod = Period::where('end_date','<',$this->reportModel->start_date)->where('clinic_id', $this->reportModel->clinic_id)->orderBy('start_date','desc')->first();
        if($prevPeriod) {
            $stockOpnames = StockOpname::where('period_id', $prevPeriod->id)->where('clinic_id', $this->reportModel->clinic_id)->get();
            $stockTransactionsPrev = StockTransaction::where('clinic_id', $this->reportModel->clinic_id)
                                ->whereDate('transaction_date','>',$prevPeriod->end_date)
                                ->whereDate('transaction_date','<',$this->reportModel->start_date)->get();
    
            $pharmaciesPrev = Pharmacy::where('clinic_id', $this->reportModel->clinic_id)
                            ->whereDate('transaction_date','>',$prevPeriod->end_date)
                            ->whereDate('transaction_date','<',$this->reportModel->start_date)->get();    

            foreach ($stockOpnames as $stockOpname) {
                if(!array_key_exists($stockOpname->medicine->code, $begin)) {
                    $begin[$stockOpname->medicine->code] = 0;
                }
    
                $begin[$stockOpname->medicine->code] = $begin[$stockOpname->medicine->code] + $stockOpname->qty;
            }                    
        } else {
            $stockTransactionsPrev = StockTransaction::where('clinic_id', $this->reportModel->clinic_id)
                                ->whereDate('transaction_date','<',$this->reportModel->start_date)->get();
    
            $pharmaciesPrev = Pharmacy::where('clinic_id', $this->reportModel->clinic_id)
                            ->whereDate('transaction_date','<',$this->reportModel->start_date)->get();    
        }

        foreach ($pharmaciesPrev as $pharmacy) {
            foreach ($pharmacy->details as $detail) {
                if(!array_key_exists($detail->medicine->code, $begin)) {
                    $begin[$detail->medicine->code] = 0;
                }
                $begin[$detail->medicine->code] = $begin[$detail->medicine->code] - $detail->actual_qty;
            }
        }

        foreach ($stockTransactionsPrev as $stockTransaction) {
            foreach ($stockTransaction->details as $detail) {
                if($stockTransaction->transaction_type == "In" || $stockTransaction->transaction_type == "Transfer In" || $stockTransaction->transaction_type == "Adjustment") {
                    if(!array_key_exists($detail->medicine->code, $begin)) {
                        $begin[$detail->medicine->code] = 0;
                    }
                    $begin[$detail->medicine->code] = $begin[$detail->medicine->code] + $detail->qty;
                } else if($stockTransaction->transaction_type == "Transfer Out") {
                    if(!array_key_exists($detail->medicine->code, $begin)) {
                        $begin[$detail->medicine->code] = 0;
                    }
                    $begin[$detail->medicine->code] = $begin[$detail->medicine->code] - $detail->qty;
                }
            }
        }

        $stockTransactions = StockTransaction::where('clinic_id', $this->reportModel->clinic_id)
                            ->whereDate('transaction_date','>=',$this->reportModel->start_date)
                            ->whereDate('transaction_date','<=',$this->reportModel->end_date)->get();

        $pharmacies = Pharmacy::where('clinic_id', $this->reportModel->clinic_id)
                    ->whereDate('transaction_date','>=',$this->reportModel->start_date)
                    ->whereDate('transaction_date','<=',$this->reportModel->end_date)->get();

        foreach ($pharmacies as $pharmacy) {
            $date = Carbon::parse($pharmacy->transaction_date)->isoFormat("D");
            foreach ($pharmacy->details as $detail) {
                if(!array_key_exists($detail->medicine->code, $out)) {
                    $out[$detail->medicine->code] = 0;
                }
                $out[$detail->medicine->code] = $out[$detail->medicine->code] + $detail->actual_qty;

                if(!array_key_exists($detail->medicine->code.$date, $outDate)) {
                    $outDate[$detail->medicine->code.$date] = 0;
                }
                $outDate[$detail->medicine->code.$date] = $outDate[$detail->medicine->code.$date] + $detail->actual_qty;                    
            }
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

                    if(!array_key_exists($detail->medicine->code.$stockTransaction->newClinic->code, $transferOutClinic)) {
                        $transferOutClinic[$detail->medicine->code.$stockTransaction->newClinic->code] = 0;
                    }
                    $transferOutClinic[$detail->medicine->code.$stockTransaction->newClinic->code] = $transferOutClinic[$detail->medicine->code.$stockTransaction->newClinic->code] + $detail->qty;    
                } else if($stockTransaction->transaction_type == "Adjustment") {
                    if(!array_key_exists($detail->medicine->code, $adj)) {
                        $adj[$detail->medicine->code] = 0;
                    }
                    $adj[$detail->medicine->code] = $adj[$detail->medicine->code] + $detail->qty;    
                }
            }
        }

        if($this->reportModel->report_format == "Induk") {
            $clinics = array();
            $clinicDb = Clinic::where('id','<>',$this->reportModel->clinic_id)->orderBy('code', 'asc')->get();
            foreach ($clinicDb as $clinic) {
                if (!array_key_exists($clinic->estate->company->code, $clinics))
                {
                    $clinics[$clinic->estate->company->code] = array();
                }

                array_push($clinics[$clinic->estate->company->code], $clinic);
            }

            return view('report.stock.template-induk', [
                "reportModel"=> $this->reportModel,
                "medicines"=> $medicines,
                "begin"=> $begin,
                "in"=> $in,
                "transferIn"=> $transferIn,
                "transferOut"=> $transferOut,
                "out"=> $out,
                "adj"=> $adj,
                "clinics"=> $clinics,
                "clinicCount"=> count($clinicDb),
                "transferOutClinic"=> $transferOutClinic,
            ]);
        }
        else if($this->reportModel->report_format == "Estate") {
            return view('report.stock.template-estate', [
                "reportModel"=> $this->reportModel,
                "medicines"=> $medicines,
                "begin"=> $begin,
                "in"=> $in,
                "transferIn"=> $transferIn,
                "transferOut"=> $transferOut,
                "out"=> $out,
                "adj"=> $adj,
                "outDate"=> $outDate,
            ]);
        } else {
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
}
