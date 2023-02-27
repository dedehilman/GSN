<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Outpatient;
use Illuminate\Support\Facades\DB;

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
        $datas = Outpatient::where('clinic_id', $this->reportModel->clinic_id)
                ->join('actions', function ($join) {
                    $join->on('actions.model_id', '=', 'outpatients.id');
                    $join->on('actions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                })
                ->select('outpatients.*');
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

            foreach ($prescriptions as $prescription) {
                $price = $prescription->medicine->price($data->transaction_date);
                $total = $prescription->qty * $price;
                $prescription->setAttribute("price", $price);
                $prescription->setAttribute("total", $total);
            }

            $data->setAttribute("diagnoses", $diagnoses);
            $data->setAttribute("prescriptions", $prescriptions);
        }

        
        return view('report.outpatient.template', [
            "reportModel"=> $this->reportModel,
            "datas"=> $datas,
        ]);
    }
}
