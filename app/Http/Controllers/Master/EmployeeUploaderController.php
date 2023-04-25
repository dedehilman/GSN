<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppUploaderController;
use Illuminate\Support\Facades\Validator;
use Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\EmployeeUploader;
use App\Models\Employee;
use App\Models\Afdelink;
use App\Models\WorkUnit;
use App\Models\Grade;
use DateTime;

class EmployeeUploaderController extends AppUploaderController
{

    public function __construct()
    {
        // $this->setDefaultUploaderMiddleware('employee');
        $this->setIndex('master.employee.uploader.index');
        $this->setUploader('master.employee.uploader.uploader');
        $this->setView('master.employee.uploader.view');
        $this->setModel('App\Models\EmployeeUploader');
        $this->setRedirect('/master/employee/uploader/index');
    }

    protected function loadRecord($row)
    {
        $record = new EmployeeUploader();
        $record->code = $row[0] ?? null;
        $record->name = $row[1] ?? null;
        $record->birth_place = $row[2] ?? null;
        $record->birth_date = $row[3] ?? null;
        $record->gender = $row[4] ?? null;
        $record->identity_number = $row[5] ?? null;
        $record->phone = $row[6] ?? null;
        $record->email = $row[7] ?? null;
        $record->address = $row[8] ?? null;
        $record->afdelink = $row[9] ?? null;
        $record->join_date = $row[10] ?? null;
        $record->no_bpjs_kesehatan = $row[11] ?? null;
        $record->no_bpjs_ketenagakerjaan = $row[12] ?? null;
        $record->work_unit = $row[13] ?? null;
        $record->grade = $row[14] ?? null;
        return $record;
    }

    protected function validateRecord($row)
    {
        $errMsg = array();
        if(!$row->code) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Code")]));
        } else if(Employee::where('code', $row->code)->first()) {
            array_push($errMsg, Lang::get('validation.exist', ["attribute"=>Lang::get("Code")]));
        }
        if(!$row->name) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Name")]));
        }
        if(!$row->birth_date) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Birth Date")]));
        } else {
            $dateFormat = DateTime::createFromFormat('Y-m-d', $row->birth_date);
            if(!$dateFormat) {
                array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Birth Date")]));
            }
        }
        if($row->gender && $row->gender != 'Male' && $row->gender != 'Female') {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Gender")]));
        }
        if(!$row->afdelink) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Afdelink")]));
        } else if(!Afdelink::where('code', $row->afdelink)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Afdelink")]));
        }
        if($row->work_unit && !WorkUnit::where('code', $row->work_unit)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Work Unit")]));
        }
        if($row->grade && !Grade::where('code', $row->grade)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Grade")]));
        }
        if($row->join_date) { 
            $dateFormat = DateTime::createFromFormat('Y-m-d', $row->join_date);
            if(!$dateFormat) {
                array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Join Date")]));
            }
        }
        return $errMsg;
    }

    protected function commitRecord($row)
    {
        $afdelink = Afdelink::where('code', $row->afdelink)->first();
        $workUnit = WorkUnit::where('code', $row->work_unit)->first();
        $grade = Grade::where('code', $row->grade)->first();

        $data = new Employee();
        $data->code = $row->code;
        $data->name = $row->name;
        $data->birth_place = $row->birth_place;
        $data->birth_date = $row->birth_date;
        $data->gender = $row->gender;
        $data->identity_number = $row->identity_number;
        $data->phone = $row->phone;
        $data->email = $row->email;
        $data->address = $row->address;
        $data->join_date = $row->join_date;
        $data->no_bpjs_kesehatan = $row->no_bpjs_kesehatan;
        $data->no_bpjs_ketenagakerjaan = $row->no_bpjs_ketenagakerjaan;
        $data->afdelink_id = $afdelink->id;
        $data->work_unit_id = $workUnit->id ?? null;
        $data->grade_id = $grade->id ?? null;
        $data->save();
    }
}
