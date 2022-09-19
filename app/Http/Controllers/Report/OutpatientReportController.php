<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class OutpatientReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('outpatient');
        $this->setDefaultView('report.outpatient');
        $this->setModel('App\Models\OutpatientReport');
    }

    protected function submitJob($data)
    {
        $data->code = "RJL-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\OutpatientExport', $data, 'reports/outpatient/');
    }
}
