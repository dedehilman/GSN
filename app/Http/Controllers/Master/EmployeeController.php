<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\AppCrudController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Lang;
use App\Models\Employee;
use App\Models\EmployeeCompany;
use App\Models\EmployeeDepartment;
use App\Models\EmployeePosition;
use App\Models\EmployeeAttribute;
use App\Models\EmployeeRelationship;
use App\Models\EmployeeAfdelink;
use PDF;
use QrCode;

class EmployeeController extends AppCrudController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('employee');
        $this->setDefaultView('master.employee');
        $this->setSelect('master.employee.select');
        $this->setModel('App\Models\Employee');
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
            $data = new Employee();
            $data->code = $request->code;
            $data->name = $request->name;
            $data->birth_place = $request->birth_place;
            $data->birth_date = $request->birth_date;
            $data->gender = $request->gender;
            $data->identity_number = $request->identity_number;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->join_date = $request->join_date;
            $data->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
            $data->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
            $data->afdelink_id = $request->afdelink_id;
            $data->save();

            if($request->employee_company_id)
            {
                $ids = array_filter($request->employee_company_id); 
                EmployeeCompany::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_company_id); $i++)
                {
                    $detail = EmployeeCompany::where('employee_id', $data->id)->where('id', $request->employee_company_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeCompany();
                    }

                    $detail->employee_id = $data->id;
                    $detail->company_id = $request->company_id[$i];
                    $detail->effective_date = $request->company_effective_date[$i];
                    $detail->expiry_date = $request->company_expiry_date[$i];
                    $detail->is_default = $request->company_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeCompany::where('employee_id', $data->id)->delete();
            }

            if($request->employee_department_id)
            {
                $ids = array_filter($request->employee_department_id); 
                EmployeeDepartment::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_department_id); $i++)
                {
                    $detail = EmployeeDepartment::where('employee_id', $data->id)->where('id', $request->employee_department_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeDepartment();
                    }

                    $detail->employee_id = $data->id;
                    $detail->department_id = $request->department_id[$i];
                    $detail->effective_date = $request->department_effective_date[$i];
                    $detail->expiry_date = $request->department_expiry_date[$i];
                    $detail->is_default = $request->department_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeDepartment::where('employee_id', $data->id)->delete();
            }

            if($request->employee_position_id)
            {
                $ids = array_filter($request->employee_position_id); 
                EmployeePosition::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_position_id); $i++)
                {
                    $detail = EmployeePosition::where('employee_id', $data->id)->where('id', $request->employee_position_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeePosition();
                    }

                    $detail->employee_id = $data->id;
                    $detail->position_id = $request->position_id[$i];
                    $detail->effective_date = $request->position_effective_date[$i];
                    $detail->expiry_date = $request->position_expiry_date[$i];
                    $detail->is_default = $request->position_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeePosition::where('employee_id', $data->id)->delete();
            }

            if($request->employee_attribute_id)
            {
                $ids = array_filter($request->employee_attribute_id); 
                EmployeeAttribute::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_attribute_id); $i++)
                {
                    $detail = EmployeeAttribute::where('employee_id', $data->id)->where('id', $request->employee_attribute_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeAttribute();
                    }

                    $detail->employee_id = $data->id;
                    $detail->attribute_id = $request->attribute_id[$i];
                    $detail->effective_date = $request->attribute_effective_date[$i];
                    $detail->expiry_date = $request->attribute_expiry_date[$i];
                    $detail->is_default = $request->attribute_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeAttribute::where('employee_id', $data->id)->delete();
            }

            if($request->employee_afdelink_id)
            {
                $ids = array_filter($request->employee_afdelink_id); 
                EmployeeAfdelink::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_afdelink_id); $i++)
                {
                    $detail = EmployeeAfdelink::where('employee_id', $data->id)->where('id', $request->employee_afdelink_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeAfdelink();
                    }

                    $detail->employee_id = $data->id;
                    $detail->afdelink_id = $request->afdelink_id[$i];
                    $detail->effective_date = $request->afdelink_effective_date[$i];
                    $detail->expiry_date = $request->afdelink_expiry_date[$i];
                    $detail->is_default = $request->afdelink_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeAfdelink::where('employee_id', $data->id)->delete();
            }

            if($request->employee_relationship_id)
            {
                $ids = array_filter($request->employee_relationship_id); 
                EmployeeRelationship::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_relationship_id); $i++)
                {
                    $detail = EmployeeRelationship::where('employee_id', $data->id)->where('id', $request->employee_relationship_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeRelationship();
                    }

                    $detail->employee_id = $data->id;
                    $detail->relationship_id = $request->relationship_id[$i];
                    $detail->identity_number = $request->employee_identity_number[$i];
                    $detail->name = $request->employee_name[$i];
                    $detail->birth_place = $request->employee_birth_place[$i];
                    $detail->birth_date = $request->employee_birth_date[$i];
                    $detail->gender = $request->employee_gender[$i];
                    $detail->phone = $request->employee_phone[$i];
                    $detail->email = $request->employee_email[$i];
                    $detail->address = $request->employee_address[$i];
                    $detail->save();
                }    
            } else {
                EmployeeRelationship::where('employee_id', $data->id)->delete();
            }
            
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
            $data->code = $request->code;
            $data->name = $request->name;
            $data->birth_place = $request->birth_place;
            $data->birth_date = $request->birth_date;
            $data->gender = $request->gender;
            $data->identity_number = $request->identity_number;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->join_date = $request->join_date;
            $data->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
            $data->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
            $data->afdelink_id = $request->afdelink_id;
            $data->save();

            if($request->employee_company_id)
            {
                $ids = array_filter($request->employee_company_id); 
                EmployeeCompany::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_company_id); $i++)
                {
                    $detail = EmployeeCompany::where('employee_id', $data->id)->where('id', $request->employee_company_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeCompany();
                    }

                    $detail->employee_id = $data->id;
                    $detail->company_id = $request->company_id[$i];
                    $detail->effective_date = $request->company_effective_date[$i];
                    $detail->expiry_date = $request->company_expiry_date[$i];
                    $detail->is_default = $request->company_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeCompany::where('employee_id', $data->id)->delete();
            }

            if($request->employee_department_id)
            {
                $ids = array_filter($request->employee_department_id); 
                EmployeeDepartment::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_department_id); $i++)
                {
                    $detail = EmployeeDepartment::where('employee_id', $data->id)->where('id', $request->employee_department_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeDepartment();
                    }

                    $detail->employee_id = $data->id;
                    $detail->department_id = $request->department_id[$i];
                    $detail->effective_date = $request->department_effective_date[$i];
                    $detail->expiry_date = $request->department_expiry_date[$i];
                    $detail->is_default = $request->department_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeDepartment::where('employee_id', $data->id)->delete();
            }

            if($request->employee_position_id)
            {
                $ids = array_filter($request->employee_position_id); 
                EmployeePosition::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_position_id); $i++)
                {
                    $detail = EmployeePosition::where('employee_id', $data->id)->where('id', $request->employee_position_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeePosition();
                    }

                    $detail->employee_id = $data->id;
                    $detail->position_id = $request->position_id[$i];
                    $detail->effective_date = $request->position_effective_date[$i];
                    $detail->expiry_date = $request->position_expiry_date[$i];
                    $detail->is_default = $request->position_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeePosition::where('employee_id', $data->id)->delete();
            }

            if($request->employee_attribute_id)
            {
                $ids = array_filter($request->employee_attribute_id); 
                EmployeeAttribute::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_attribute_id); $i++)
                {
                    $detail = EmployeeAttribute::where('employee_id', $data->id)->where('id', $request->employee_attribute_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeAttribute();
                    }

                    $detail->employee_id = $data->id;
                    $detail->attribute_id = $request->attribute_id[$i];
                    $detail->effective_date = $request->attribute_effective_date[$i];
                    $detail->expiry_date = $request->attribute_expiry_date[$i];
                    $detail->is_default = $request->attribute_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeAttribute::where('employee_id', $data->id)->delete();
            }

            if($request->employee_afdelink_id)
            {
                $ids = array_filter($request->employee_afdelink_id); 
                EmployeeAfdelink::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_afdelink_id); $i++)
                {
                    $detail = EmployeeAfdelink::where('employee_id', $data->id)->where('id', $request->employee_afdelink_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeAfdelink();
                    }

                    $detail->employee_id = $data->id;
                    $detail->afdelink_id = $request->afdelink_id[$i];
                    $detail->effective_date = $request->afdelink_effective_date[$i];
                    $detail->expiry_date = $request->afdelink_expiry_date[$i];
                    $detail->is_default = $request->afdelink_is_default[$i];
                    $detail->save();
                }    
            } else {
                EmployeeAfdelink::where('employee_id', $data->id)->delete();
            }

            if($request->employee_relationship_id)
            {
                $ids = array_filter($request->employee_relationship_id); 
                EmployeeRelationship::where('employee_id', $data->id)->whereNotIn('id', $ids)->delete();

                for($i=0; $i<count($request->employee_relationship_id); $i++)
                {
                    $detail = EmployeeRelationship::where('employee_id', $data->id)->where('id', $request->employee_relationship_id[$i])->first();
                    if(!$detail)
                    {
                        $detail = new EmployeeRelationship();
                    }

                    $detail->employee_id = $data->id;
                    $detail->relationship_id = $request->relationship_id[$i];
                    $detail->identity_number = $request->employee_identity_number[$i];
                    $detail->name = $request->employee_name[$i];
                    $detail->birth_place = $request->employee_birth_place[$i];
                    $detail->birth_date = $request->employee_birth_date[$i];
                    $detail->gender = $request->employee_gender[$i];
                    $detail->phone = $request->employee_phone[$i];
                    $detail->email = $request->employee_email[$i];
                    $detail->address = $request->employee_address[$i];
                    $detail->save();
                }    
            } else {
                EmployeeRelationship::where('employee_id', $data->id)->delete();
            }

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
            'code' => 'required|max:255|unique:employees',
            'name' => 'required|max:255',
            'afdelink_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:employees,code,'.$id,
            'name' => 'required|max:255',
            'afdelink_id' => 'required',
        ]);

        if($validator->fails()){
            return $validator->errors()->all();
        }
    }

    public function download($id, Request $request)
    {
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        $clinic = \App\Models\Clinic::find(1);
        $pdf = PDF::loadview('master.employee.card', [
            'data' => $data,
            'clinic' => $clinic,
            'qrcode' => base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate('string')),
        ]);
        return $pdf->download($data->code.'.pdf');
    }
}
