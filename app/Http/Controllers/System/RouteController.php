<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;
use App\Models\RouteRouteType;
use App\Models\Sequence;
use Illuminate\Support\Facades\DB;
use Lang;

class RouteController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('route');
        $this->setIndex('system.route.index');
        $this->setCreate('system.route.create');
        $this->setEdit('system.route.edit');
        $this->setView('system.route.view');
        $this->setModel('App\Models\Route');
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
            $data = new Route();
            $data->name = $request->name;
            $data->sequence_number = $request->sequence_number;
            $data->sequence_id = Sequence::where('name', $request->sequence_name)->first()->id;
            
            $data->save();
            $routeTypes = array();
            for($i=0; $i<count($request->routeTypes ?? []); $i++)
            {
                array_push($routeTypes, new RouteRouteType(['route_type' => $request->routeTypes[$i]]));
            }
            $data->syncRouteTypes($routeTypes);
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
            $data->name = $request->name;
            $data->sequence_number = $request->sequence_number;
            $data->sequence_id = Sequence::where('name', $request->sequence_name)->first()->id;
            
            $data->save();
            $routeTypes = array();
            for($i=0; $i<count($request->routeTypes ?? []); $i++)
            {
                array_push($routeTypes, new RouteRouteType(['route_type' => $request->routeTypes[$i]]));
            }
            $data->syncRouteTypes($routeTypes);
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
            'name' => 'required|max:255|unique:routes',
            'sequence_name' => 'required',
            'sequence_number' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:routes,name,'.$id,
            'sequence_name' => 'required',
            'sequence_number' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
