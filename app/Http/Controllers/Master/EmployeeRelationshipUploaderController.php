<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppUploaderController;
use Illuminate\Support\Facades\Validator;
use Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\EmployeeRelationshipUploader;
use App\Models\EmployeeRelationship;
use App\Models\Employee;
use App\Models\Relationship;
use DateTime;

class EmployeeRelationshipUploaderController extends AppUploaderController
{

    public function __construct()
    {
        // $this->setDefaultUploaderMiddleware('employee-relationship');
        $this->setIndex('master.employee-relationship.uploader.index');
        $this->setUploader('master.employee-relationship.uploader.uploader');
        $this->setView('master.employee-relationship.uploader.view');
        $this->setModel('App\Models\EmployeeRelationshipUploader');
        $this->setRedirect('/master/employee-relationship/uploader/index');
    }

    protected function loadRecord($row)
    {
        $record = new EmployeeRelationshipUploader();
        $record->employee = $row[0] ?? null;
        $record->relationship = $row[1] ?? null;
        $record->name = $row[2] ?? null;
        $record->birth_place = $row[3] ?? null;
        $record->birth_date = $row[4] ?? null;
        $record->gender = $row[5] ?? null;
        $record->identity_number = $row[6] ?? null;
        $record->phone = $row[7] ?? null;
        $record->email = $row[8] ?? null;
        $record->address = $row[9] ?? null;
        return $record;
    }

    protected function validateRecord($row)
    {
        $errMsg = array();
        if(!$row->employee) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Employee")]));
        } else if(!Employee::where('code', $row->employee)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Employee")]));
        }
        if(!$row->relationship) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Relationship")]));
        } else if(!Relationship::where('code', $row->relationship)->first()) {
            array_push($errMsg, Lang::get('validation.invalid', ["attribute"=>Lang::get("Relationship")]));
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
        if(!$row->identity_number) {
            array_push($errMsg, Lang::get('validation.required', ["attribute"=>Lang::get("Identity Number")]));
        }
        return $errMsg;
    }

    protected function commitRecord($row)
    {
        $employee = Employee::where('code', $row->employee)->first();
        $relationship = Relationship::where('code', $row->relationship)->first();

        $data = new EmployeeRelationship();
        $data->employee_id = $employee->id;
        $data->relationship_id = $relationship->id;
        $data->name = $row->name;
        $data->birth_place = $row->birth_place;
        $data->birth_date = $row->birth_date;
        $data->gender = $row->gender;
        $data->identity_number = $row->identity_number;
        $data->phone = $row->phone;
        $data->email = $row->email;
        $data->address = $row->address;
        $data->save();
    }
}
