<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class SickLetterReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('sick-letter');
        $this->setDefaultView('report.sick-letter');
        $this->setModel('App\Models\SickLetterReport');
    }

    protected function submitJob($data)
    {
        $data->code = "SKS-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\SickLetterExport', $data, 'reports/letter/sick-letter/');
    }
}
