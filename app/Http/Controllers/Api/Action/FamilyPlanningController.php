<?php

namespace App\Http\Controllers\Api\Action;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Action\ActionController;
use Illuminate\Support\Facades\Validator;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilyPlanningController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-family-planning');
        $this->setModel('App\Models\FamilyPlanning');
    }

    public function store(Request $request)
    {
        try {
            $transactionNo = FamilyPlanning::where('transaction_no', 'LIKE', 'KB-'.Carbon::parse($request->transaction_date)->isoFormat('YYYYMMDD').'-%')->orderBy('transaction_no', 'desc')->first();
			$count = 0;
			try {
				$count = (int) Str::substr($transactionNo->transaction_no, -5);
			} catch (\Throwable $th) {
			}
            $request['transaction_no'] = 'KB-'.Carbon::now()->isoFormat('YYYYMMDD').'-'.str_pad(($count +1), 5, '0', STR_PAD_LEFT);

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
