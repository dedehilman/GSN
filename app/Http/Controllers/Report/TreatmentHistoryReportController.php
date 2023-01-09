<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class TreatmentHistoryReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('treatment-history');
        $this->setDefaultView('report.treatment-history');
        $this->setModel('App\Models\TreatmentHistory');
    }

    protected function submitJob($data)
    {
        $data->code = "HIS-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\TreatmentHistoryExport', $data, 'reports/treatment-history/');
    }
}
