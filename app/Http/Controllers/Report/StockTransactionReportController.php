<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\AppReportController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AppReportJob;

class StockTransactionReportController extends AppReportController
{
    public function __construct()
    {
        $this->setDefaultMiddleware('stock-transaction');
        $this->setDefaultView('report.stock-transaction');
        $this->setModel('App\Models\StockTransactionReport');
    }

    protected function submitJob($data)
    {
        $data->code = "INV-".$data->id;
        $data->save();

        AppReportJob::dispatch('App\Exports\StockTransactionExport', $data, 'reports/inventory/stock-transaction/');
    }
}
