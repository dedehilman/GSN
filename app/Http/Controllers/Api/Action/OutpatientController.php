<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Action\ActionController;
use Illuminate\Support\Facades\Validator;
use App\Models\Outpatient;
use Carbon\Carbon;
use Lang;
use Illuminate\Support\Facades\DB;

class OutpatientController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-outpatient');
        $this->setModel('App\Models\Outpatient');
    }

    public function store(Request $request)
    {
        try {
            $count = Outpatient::whereDate('transaction_date', Carbon::now()->isoFormat('YYYY-MM-DD'))->count();
            $request['transaction_no'] = 'RJL-'.Carbon::now()->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }
            DB::beginTransaction();
            $data = $this->model::create($request->all());
            $this->documentHandler($data, $request);
            $this->actionHandler($data, $request);
            $this->prescriptionHandler($data, $request);
            $this->diagnosisHandler($data, $request);

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => $data,
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }
}
