<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class FamilyPlanningReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('family-planning');
        $this->setDefaultView('report.family-planning');
        $this->setModel('App\Models\FamilyPlanningReport');
    }

    protected function submitJob($data)
    {
        $data->code = "KB-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\FamilyPlanningExport', $data, 'reports/family-planning/');
    }
}
