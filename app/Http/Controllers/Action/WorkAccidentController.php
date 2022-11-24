<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\WorkAccident;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use Illuminate\Support\Str;

class WorkAccidentController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-work-accident');
        $this->setDefaultView('action.work-accident');
        $this->setModel('App\Models\WorkAccident');
    }

    public function edit(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        if(($data->action()->status ?? "") == "Publish") {
            if(Str::contains($request->path(), '/edit')) {
                return redirect(route('action.work-accident.show', $data->id));
            }
        }
        return view($this->edit, compact('data'));
    }
}

