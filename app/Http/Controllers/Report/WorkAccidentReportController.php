<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class WorkAccidentReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('work-accident');
        $this->setDefaultView('report.work-accident');
        $this->setModel('App\Models\WorkAccidentReport');
    }

    protected function submitJob($data)
    {
        $data->code = "KK-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\WorkAccidentExport', $data, 'reports/work-accident/');
    }
}
