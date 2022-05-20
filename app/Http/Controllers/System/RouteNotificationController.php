<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;
use App\Models\RouteNotification;
use Illuminate\Support\Facades\DB;
use Lang;

class RouteNotificationController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('route-notification');
        $this->setIndex('system.route-notification.index');
        $this->setCreate('system.route-notification.create');
        $this->setEdit('system.route-notification.edit');
        $this->setView('system.route-notification.view');
        $this->setModel('App\Models\RouteNotification');
        $this->setParentModel('App\Models\Route');
    }

    public function validateOnStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workflow_trigger' => 'required',
            'workflow_recipient' => 'required',
            'notification_template_id' => 'required',
            'route_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'workflow_trigger' => 'required',
            'workflow_recipient' => 'required',
            'notification_template_id' => 'required',
            'route_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }
}
