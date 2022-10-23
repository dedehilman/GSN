<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\AppUploaderController;
use Illuminate\Support\Facades\Validator;
use Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\StockOpnameUploader;
use App\Models\Period;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\StockOpname;

class StockOpnameUploaderController extends AppUploaderController
{

    public function __construct()
    {
        $this->setDefaultUploaderMiddleware('stock-opname');
        $this->setIndex('inventory.stock-opname.uploader.index');
        $this->setUploader('inventory.stock-opname.uploader.uploader');
        $this->setView('inventory.stock-opname.uploader.view');
        $this->setModel('App\Models\StockOpnameUploader');
        $this->setRedirect('/inventory/stock-opname/uploader/index');
    }

    protected function loadRecord($row)
    {
        $record = new StockOpnameUploader();
        $record->period = $row[0] ?? null;
        $record->medicine = $row[1] ?? null;
        $record->clinic = $row[2] ?? null;
        $record->qty = $row[3] ?? null;
        return $record;
    }

    protected function validateRecord($row)
    {
        $errMsg = array();
        if(!$row->period) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Period")]));
        } else if(!Period::where('code', $row->period)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Period")]));
        }
        if(!$row->medicine) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Product")]));
        } else if(!Medicine::where('code', $row->medicine)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Product")]));
        }
        if(!$row->clinic) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Clinic")]));
        } else if(!Clinic::where('code', $row->clinic)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Clinic")]));
        }
        if(!$row->qty) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Qty")]));
        } else if(!is_numeric($row->qty)) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Qty")]));
        }
        return $errMsg;
    }

    protected function commitRecord($row)
    {
        $period = Period::where('code', $row->period)->first();
        $clinic = Clinic::where('code', $row->clinic)->first();
        $medicine = Medicine::where('code', $row->medicine)->first();
        $data = StockOpname::where('period_id', $period->id)->where('clinic_id', $clinic->id)->where('medicine_id', $medicine->id)->first();
        if(!$data) {
            $data = new StockOpname();
        }
        $data->period_id = $period->id;
        $data->clinic_id = $clinic->id;
        $data->medicine_id = $medicine->id;
        $data->qty = $row->qty;        
        $data->save();
    }
}
