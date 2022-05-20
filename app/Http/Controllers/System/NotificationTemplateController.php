<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\NotificationTemplate;
use App\Models\NotificationTemplateNotificationType;
use Illuminate\Support\Facades\DB;
use Lang;

class NotificationTemplateController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('notification-template');
        $this->setSelect('system.notification-template.select');
        $this->setIndex('system.notification-template.index');
        $this->setCreate('system.notification-template.create');
        $this->setEdit('system.notification-template.edit');
        $this->setView('system.notification-template.view');
        $this->setModel('App\Models\NotificationTemplate');
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
            $data = new NotificationTemplate();
            $data->name = $request->name;
            $data->subject = $request->subject;
            $data->body = $request->body;
            
            $data->save();
            $notificationTypes = array();
            for($i=0; $i<count($request->notificationTypes ?? []); $i++)
            {
                array_push($notificationTypes, new NotificationTemplateNotificationType(['notification_type' => $request->notificationTypes[$i]]));
            }
            $data->syncNotificationTypes($notificationTypes);
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
            $data->subject = $request->subject;
            $data->body = $request->body;
            
            $data->save();
            $notificationTypes = array();
            for($i=0; $i<count($request->notificationTypes ?? []); $i++)
            {
                array_push($notificationTypes, new NotificationTemplateNotificationType(['notification_type' => $request->notificationTypes[$i]]));
            }
            $data->syncNotificationTypes($notificationTypes);
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
            'name' => 'required|max:255|unique:notification_templates',
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:notification_templates,name,'.$id,
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
