<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use Storage;

abstract class AppReportController extends AppCrudController
{

    abstract protected function submitJob($data);

    public function setDefaultMiddleware($permission) {
        $this->middleware('auth');
        $this->middleware('permission:'.$permission.'-report-list|'.$permission.'-report-create|'.$permission.'-report-download', ['only' => ['index','show']]);
        $this->middleware('permission:'.$permission.'-report-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$permission.'-report-download', ['only' => ['download']]);
    }

    public function download($id)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        if($data->file_path == null || $data->file_path == '' || !Storage::exists($data->file_path)) {
            return redirect()->back()->with(['info' => Lang::get("File not found")]);
        }

        $data->num_of_downloaded = $data->num_of_downloaded + 1;
        $data->save();

        return Storage::download($data->file_path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

            $data = $this->model::create($request->all());
            $this->submitJob($data);

            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            if($data->status == 1) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Cannot delete this data")
                ]);
            }

            $data->delete();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been deleted")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }
    }
}
