<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\MediaTmp;
use Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MediaController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('media');
        $this->setDefaultView('system.media');
        $this->setModel('App\Models\Media');
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

            $data = new MediaTmp();
            $data->save();
            foreach ($request->input('document', []) as $file) {
                $data->addMedia(storage_path('media/' . $file))->toMediaCollection('media', 'media');;
            }

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

            $modelType = $data->model_type;
            $modelId = $data->model_id;
            Storage::disk("media")->deleteDirectory($data->id);
            $data->delete();
            if($modelType == "App\Models\MediaTmp") {
                $count = DB::table("media")->where("model_type", $modelType)->where("model_id", $modelId)->count();
                if($count == 0) {
                    DB::table("media_tmps")->where("id", $modelId)->delete();
                }                
            }
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

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
