<?php

namespace App\Http\Controllers\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lang;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppMail;
use Storage;
use Illuminate\Support\Str;

class FamilyPlanningController extends ActionController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('action-family-planning');
        $this->setDefaultView('action.family-planning');
        $this->setModel('App\Models\FamilyPlanning');
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
                return redirect(route('action.family-planning.show', $data->id));
            }
        }
        return view($this->edit, compact('data'));
    }
}

