<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class StockReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('stock');
        $this->setDefaultView('report.stock');
        $this->setModel('App\Models\StockReport');
    }

    protected function submitJob($data)
    {
        $data->code = "INV-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\StockExport', $data, 'reports/inventory/stock/');
    }
}
