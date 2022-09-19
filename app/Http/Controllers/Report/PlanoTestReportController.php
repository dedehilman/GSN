<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class PlanoTestReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('plano-test');
        $this->setDefaultView('report.plano-test');
        $this->setModel('App\Models\PlanoTestReport');
    }

    protected function submitJob($data)
    {
        $data->code = "PPT-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\PlanoTestExport', $data, 'reports/plano-test/');
    }
}
