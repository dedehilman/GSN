<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\AppCrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StockTransaction;
use App\Models\StockTransactionDetail;
use Illuminate\Support\Facades\DB;
use Lang;

class StockTransactionController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('stock-transaction');
        $this->setSelect('inventory.stock-transaction.select');
        $this->setIndex('inventory.stock-transaction.index');
        $this->setCreate('inventory.stock-transaction.create');
        $this->setEdit('inventory.stock-transaction.edit');
        $this->setView('inventory.stock-transaction.view');
        $this->setModel('App\Models\StockTransaction');
    }

    public function store(Request $request)
    {
        try {
            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }

            DB::beginTransaction();
            $data = new StockTransaction();
            $data->transaction_no = $request->transaction_no;
            $data->transaction_date = $request->transaction_date;
            $data->transaction_type = $request->transaction_type;
            $data->reference = $request->reference;
            $data->remark = $request->remark;
            $data->clinic_id = $request->clinic_id;
            $data->new_clinic_id = $request->new_clinic_id;
            $data->save();

            if($request->transaction_detail_id)
            {
                $ids = array_filter($request->transaction_detail_id); 
                StockTransactionDetail::where('stock_transaction_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->transaction_detail_id); $i++)
                {
                    $detail = StockTransactionDetail::where('stock_transaction_id', $data->id)->where('id', $request->transaction_detail_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new StockTransactionDetail();
                    }

                    $detail->stock_transaction_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->remark = $request->detail_remark[$i];
                    $detail->save();
                }    
            } else {
                StockTransactionDetail::where('stock_transaction_id', $data->id)->delete();
            }
            
            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
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

    public function update(Request $request, $id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnUpdate
                ]);
            }

            DB::beginTransaction();
            $data->transaction_no = $request->transaction_no;
            $data->transaction_date = $request->transaction_date;
            $data->transaction_type = $request->transaction_type;
            $data->reference = $request->reference;
            $data->remark = $request->remark;
            $data->clinic_id = $request->clinic_id;
            $data->new_clinic_id = $request->new_clinic_id;
            $data->save();

            if($request->transaction_detail_id)
            {
                $ids = array_filter($request->transaction_detail_id); 
                StockTransactionDetail::where('stock_transaction_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->transaction_detail_id); $i++)
                {
                    $detail = StockTransactionDetail::where('stock_transaction_id', $data->id)->where('id', $request->transaction_detail_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new StockTransactionDetail();
                    }

                    $detail->stock_transaction_id = $data->id;
                    $detail->medicine_id = $request->medicine_id[$i];
                    $detail->qty = $request->qty[$i];
                    $detail->remark = $request->detail_remark[$i];
                    $detail->save();
                }    
            } else {
                StockTransactionDetail::where('stock_transaction_id', $data->id)->delete();
            }

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been updated")
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

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required',
            'transaction_no' => 'required',
            'transaction_type' => 'required',
            'clinic_id' => 'required',
        ]);

        if($request->transaction_type == 'Transfer Out') {
            $validator->addRules([
                'new_clinic_id'=> 'required'
            ]);
        } else if($request->transaction_type == 'Transfer In') {
            $validator->addRules([
                'reference_id'=> 'required'
            ]);
        }

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required',
            'transaction_no' => 'required',
            'transaction_type' => 'required',
            'clinic_id' => 'required',
        ]);

        if($request->transaction_type == 'Transfer Out') {
            $validator->addRules([
                'new_clinic_id'=> 'required'
            ]);
        } else if($request->transaction_type == 'Transfer In') {
            $validator->addRules([
                'reference_id'=> 'required'
            ]);
        }

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
