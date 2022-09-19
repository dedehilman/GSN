<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Outpatient;

class OutpatientExport implements ShouldAutoSize, FromView
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
        $datas = Outpatient::where('clinic_id', $this->reportModel->clinic_id);
        if($this->reportModel->start_date) {
            $datas->whereDate('transaction_date', '>=', $this->reportModel->start_date);
        }
        if($this->reportModel->end_date) {
            $datas->whereDate('transaction_date', '<=', $this->reportModel->end_date);
        }

        $datas = $datas->get();

        foreach ($datas as $data) {
            $diagnoses = \App\Models\DiagnosisResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();

            $prescriptions = \App\Models\Prescription::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();


            $details = array();
            foreach ($diagnoses as $diagnosis) {
                $detail = array();
                $detail['diagnosis'] = $diagnosis->diagnosis->name;
                $detail['gol_diagnosis'] = $diagnosis->diagnosis->disease->diseaseGroup->name ?? "";
                array_push($details, $detail);
            }

            foreach ($prescriptions as $index => $prescription) {
                if(count($details) >= $index + 1) {
                    $details[$index]['terapi'] = $prescription->medicine->name;
                    $details[$index]['qty'] = $prescription->qty;
                } else {
                    $detail = array();
                    $detail['terapi'] = $prescription->medicine->name;
                    $detail['qty'] = $prescription->qty;
                    array_push($details, $detail);
                }
            }

            $data->setAttribute("details", $details);
        }

        
        return view('report.outpatient.template', [
            "reportModel"=> $this->reportModel,
            "datas"=> $datas,
        ]);
    }
}
