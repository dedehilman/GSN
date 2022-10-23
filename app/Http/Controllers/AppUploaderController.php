<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\Uploader;
use Excel;
use Carbon\Carbon;

abstract class AppUploaderController extends AppCrudController
{
    protected $uploader;
    protected $redirect;

    public function setDefaultUploaderMiddleware($permission) {
        $this->middleware('auth');
        $this->middleware('permission:'.$permission.'-upload', ['only' => ['index','show','uploader', 'uploadProcess', 'validateProcess', 'commitProcess']]);
    }

    public function setUploader($uploader) {
        $this->uploader = $uploader;
    }

    public function setRedirect($redirect) {
        $this->redirect = $redirect;
    }

    public function getTableName() {
        return with(new $this->model)->getTable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploader(Request $request)
    {
        return view($this->uploader);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uplNo = $request->uplNo ?? '';
        $rawCount = $this->model::where('upl_no', $uplNo)->where('upl_status', '0')->count();
        $validateCount = $this->model::where('upl_no', $uplNo)->whereIn('upl_status', ['1', '2'])->count();
        $commitedCount = $this->model::where('upl_no', $uplNo)->whereIn('upl_status', ['3', '4'])->count();
        $state = 0;
        if($validateCount > 0) {
            $state = 1;
        }
        if($commitedCount > 0) {
            $state = 2;
        }
        return view($this->index, compact('uplNo', 'state'));
    }

    public function uploadProcess(Request $request) 
	{
        $validator = Validator::make($request->all(), [
            'upl_no' => 'required',
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        $maxUploadSize = getParameter('MAX_UPLOAD_SIZE');
        if($maxUploadSize && $maxUploadSize != "") {
            $validator = Validator::make($request->all(), [
                'upl_no' => 'required',
                'file' => 'required|file|mimes:csv,xls,xlsx|max:'.$maxUploadSize,
            ]);   
        }
        if($validator->fails()){
            return redirect()->back()->with(['info' => $validator->errors()->all()[0]]);
        }

        $lineNo = 0;
        try {
            DB::beginTransaction();
            $this->model::whereDate('created_at', "<", Carbon::now()->addDays(-1))->delete();
            $uplNo = $request->upl_no;
            $row = Excel::toArray(new Uploader, request()->file('file'));            
            if(count($row) > 0 && count($row[0]) > 1) {
                for ($i=1; $i < count($row[0]); $i++) { 
                    $lineNo = $i;
                    $record = $this->loadRecord($row[0][$i]);
                    $record->upl_no = $uplNo;
                    $record->upl_line_no = $i;
                    $record->upl_status = '0';
                    $record->save();
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if($lineNo > 0) {
                $errMsg = Lang::get("Please check data at line number", ["lineNo" => $lineNo]).". ".$th->getMessage();
            } else {
                $errMsg = $th->getMessage();
            }            
            return redirect()->back()->with(['info' => $errMsg]);
        }
        
        return redirect($this->redirect.'?uplNo='.$uplNo);
	}

    public function validateProcess(Request $request) 
	{
        try {
            DB::beginTransaction();
            $rows = $this->model::where('upl_no', $request->upl_no ?? '')->get();
            foreach ($rows as $row) {
                $errMsg = $this->validateRecord($row);
                if($errMsg && count($errMsg) > 0) {
                    $row->upl_status = '2';
                    $row->upl_remark = implode("\n",$errMsg);
                } else {
                    $row->upl_status = '1';
                    $row->upl_remark = '';
                }
                $row->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }        

        return response()->json([
            'status' => '200',
            'data' => '',
            'message' => ''
        ]);
	}

    public function commitProcess(Request $request) 
	{
        try {
            $recordErrorCount = $this->model::where('upl_no', $request->upl_no ?? '')->where('upl_status', '2')->count();
            if($recordErrorCount > 0) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message' => Lang::get("Cannot commit record with status invalid")
                ]);
            }

            DB::beginTransaction();
            $rows = $this->model::where('upl_no', $request->upl_no ?? '')->get();
            foreach ($rows as $row) {
                $this->commitRecord($row);
                $row->upl_status = '4';
                $row->save();
            }
            $this->postCommitRecord($request);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }        

        return response()->json([
            'status' => '200',
            'data' => '',
            'message' => ''
        ]);
	}

    abstract protected function loadRecord($row);
    abstract protected function validateRecord($row);
    abstract protected function commitRecord($row);
    protected function postCommitRecord(Request $request){}
}
