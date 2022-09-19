@extends('layout', ['title' => Lang::get("Employee"), 'subTitle' => Lang::get("Create data employee")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('employee.store')}}" method="POST">
                @csrf
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">     
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Code")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="code" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Birth Place / Date")}}</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="birth_place" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" name="birth_date" class="form-control date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Gender")}}</label>
                            <div class="col-md-9 pt-2">
                                <div class="form-check d-inline mr-3">
                                    <input class="form-check-input" type="radio" name="gender" value="male">
                                    <label class="form-check-label">{{__("Male")}}</label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female">
                                    <label class="form-check-label">{{__("Female")}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Identity Number")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="identity_number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Email")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                            <div class="col-md-9">
                                <textarea name="address" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Join Date")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="join_date" class="form-control date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("BPJS Kesehatan")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="no_bpjs_kesehatan" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("BPJS Ketenagakerjaan")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="no_bpjs_ketenagakerjaan" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Afdelink")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="afdelink_name" id="afdelink_name" class="form-control required" readonly>
                                    <input type="hidden" name="afdelink_id" id="afdelink_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Afdelink List')}}" data-url="{{route('afdelink.select')}}" data-handler="onSelectedAfdelink"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Work Unit")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="work_unit_name" id="work_unit_name" class="form-control" readonly>
                                    <input type="hidden" name="work_unit_id" id="work_unit_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Work Unit List')}}" data-url="{{route('work-unit.select')}}" data-handler="onSelectedWorkUnit"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Grade")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="grade_name" id="grade_name" class="form-control" readonly>
                                    <input type="hidden" name="grade_id" id="grade_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Grade List')}}" data-url="{{route('grade.select')}}" data-handler="onSelectedGrade"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Company") }}</a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="true">{{ __("Department") }}</a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="true">{{ __("Position") }}</a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="pill" href="#tab4" role="tab" aria-selected="true">{{ __("Attribute") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab5" role="tab" aria-selected="true">{{ __("Relationship") }}</a>
                                    </li>
                                    <li class="nav-item d-none">
                                        <a class="nav-link" data-toggle="pill" href="#tab6" role="tab" aria-selected="true">{{ __("Afdelink") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade" id="tab1" role="tabpanel">
                                        <table class="table table-bordered" id="table-company">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="company" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Company') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <table class="table table-bordered" id="table-department">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="department" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Department') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <table class="table table-bordered" id="table-position">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="position" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Position') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <table class="table table-bordered" id="table-attribute">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="attribute" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Attribute') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade show active" id="tab5" role="tabpanel">
                                        <table class="table table-bordered" id="table-relationship">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm' id="btn-add-employee-relationship" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Relationship') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab6" role="tabpanel">
                                        <table class="table table-bordered" id="table-afdelink">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="afdelink" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Afdelink') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                    <th>{{ __('Default') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('employee.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-company-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="employee_company_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="company_name[]" class="form-control" readonly>
                        <input type="hidden" name="company_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Company List')}}" data-url="{{route('company.select')}}" data-handler="onSelectedCompany" data-id="company"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="company_effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="company_expiry_date[]" class="form-control date">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="isDefault(this)">
                        <input type="hidden" name="company_is_default[]" value="0">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="d-none" id="table-department-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="employee_department_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="department_name[]" class="form-control" readonly>
                        <input type="hidden" name="department_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Department List')}}" data-url="{{route('department.select')}}" data-handler="onSelectedDepartment" data-id="department"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="department_effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="department_expiry_date[]" class="form-control date">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="isDefault(this)">
                        <input type="hidden" name="department_is_default[]" value="0">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="d-none" id="table-position-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="employee_position_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="position_name[]" class="form-control" readonly>
                        <input type="hidden" name="position_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Position List')}}" data-url="{{route('position.select')}}" data-handler="onSelectedPosition" data-id="position"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="position_effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="position_expiry_date[]" class="form-control date">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="isDefault(this)">
                        <input type="hidden" name="position_is_default[]" value="0">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="d-none" id="table-attribute-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="employee_attribute_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="attribute_name[]" class="form-control" readonly>
                        <input type="hidden" name="attribute_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Attribute List')}}" data-url="{{route('attribute.select')}}" data-handler="onSelectedAttribute" data-id="attribute"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="attribute_effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="attribute_expiry_date[]" class="form-control date">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="isDefault(this)">
                        <input type="hidden" name="attribute_is_default[]" value="0">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="d-none" id="table-relationship-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" name="employee_relationship_id[]">
                    <input type="hidden" name="relationship_id[]">
                    <input type="hidden" name="employee_identity_number[]">
                    <input type="hidden" name="employee_name[]">
                    <input type="hidden" name="employee_birth_place[]">
                    <input type="hidden" name="employee_birth_date[]">
                    <input type="hidden" name="employee_gender[]">
                    <input type="hidden" name="employee_phone[]">
                    <input type="hidden" name="employee_email[]">
                    <input type="hidden" name="employee_address[]">
                </td>
                <td style="cursor: pointer;" onclick="viewEmployeeRelationship(this)"></td>
            </tr>
        </tbody>
    </table>
    <table class="d-none" id="table-afdelink-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="employee_afdelink_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="afdelink_name[]" class="form-control" readonly>
                        <input type="hidden" name="afdelink_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Afdelink List')}}" data-url="{{route('afdelink.select')}}" data-handler="onSelectedAfdelink" data-id="afdelink"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="afdelink_effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="afdelink_expiry_date[]" class="form-control date">
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="isDefault(this)">
                        <input type="hidden" name="afdelink_is_default[]" value="0">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="modal fade" data-backdrop="static" id="modalEmployeeRelationship">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Employee Relationship')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEmployeeRelationship">
                        <input type="hidden" name="id">
                        <input type="hidden" name="row">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label required">{{__("Relationship")}}</label>
                            <div class="col-md-8">
                                <select name="emp_relationship_id" class="form-control custom-select required">
                                    <option value=""></option>
                                    @foreach (\App\Models\Relationship::all() as $relationship)
                                        <option value="{{$relationship->id}}">{{$relationship->name}}</option>    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label required">{{__("Identity Number")}}</label>
                            <div class="col-md-8">
                                <input type="text" name="emp_relationship_identity_number" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-8">
                                <input type="text" name="emp_relationship_name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{__("Birth Place / Date")}}</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="emp_relationship_birth_place" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" name="emp_relationship_birth_date" class="form-control date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{__("Gender")}}</label>
                            <div class="col-md-8 pt-2">
                                <div class="form-check d-inline mr-3">
                                    <input class="form-check-input" type="radio" name="emp_relationship_gender" value="Male" checked>
                                    <label class="form-check-label">{{__("Male")}}</label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input" type="radio" name="emp_relationship_gender" value="Female">
                                    <label class="form-check-label">{{__("Female")}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{__("Phone")}}</label>
                            <div class="col-md-8">
                                <input type="text" name="emp_relationship_phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{__("Email")}}</label>
                            <div class="col-md-8">
                                <input type="text" name="emp_relationship_email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{__("Address")}}</label>
                            <div class="col-md-8">
                                <textarea name="emp_relationship_address" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
                    <button type="button" class="btn btn-primary" id="btn-save-employee-relationship">{{ __("Save") }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('.btn-add').on('click', function(){
                var type = $(this).attr("data-type");
                var clonedRow = $('#table-' + type + '-tmp tbody tr:last').clone();
                $('#table-' + type + ' tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#employee_' + type + '_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'employee_' + type + '_id' + i);
                textInput.eq(2).attr('id', type+'_name' + i);
                textInput.eq(3).attr('id', type+'_id' + i);
                textInput.eq(4).attr('id', type+'_effective_date' + i);
                textInput.eq(5).attr('id', type+'_expiry_date' + i);
                textInput.val('');
                textInput.eq(0).val(i);
                textInput.eq(7).val(0);

                $('.date').datepicker({
                    fontAwesome: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    todayBtn: false,
                    clearBtn: true,
                });
            });

            $('.btn-add-relationship').on('click', function(){
                var clonedRow = $('#table-relationship-tmp tbody tr:last').clone();
                $('#table-relationship tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#employee_relationship_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'employee_relationship_id' + i);
                textInput.eq(2).attr('id', 'relationship_name' + i);
                textInput.eq(3).attr('id', 'relationship_id' + i);
                textInput.eq(4).attr('id', 'relationship_identity_number' + i);
                textInput.eq(5).attr('id', 'relationship_identity_name' + i);
                textInput.val('');
                textInput.eq(0).val(i);
            });

            $(document).on('click', '.show-modal-select', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });

            $('#btn-add-employee-relationship').on('click', function(){
                $('#formEmployeeRelationship input[name="row"]').val('');
                $('#formEmployeeRelationship input[name="id"]').val('');
                $('#formEmployeeRelationship select[name="emp_relationship_id"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_identity_number"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_name"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_birth_place"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_birth_date"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_phone"]').val('');
                $('#formEmployeeRelationship input[name="emp_relationship_email"]').val('');
                $('#formEmployeeRelationship textarea[name="emp_relationship_address"]').val('');
                
                validatorEmployeeRelationship.resetForm();
                formEmployeeRelationship.find(".is-invalid").removeClass("is-invalid");
                $('#modalEmployeeRelationship').modal('show');
            });

            $('#btn-save-employee-relationship').on('click', function(){
                $('#formEmployeeRelationship').submit();
            });

            formEmployeeRelationship = $("#formEmployeeRelationship");
            validatorEmployeeRelationship = formEmployeeRelationship.validate({
                rules: {
                    relationship_id: "required",
                    emp_relationship_identity_number: "required",
                    emp_relationship_name: "required",
                },
                messages: {
                    relationship_id: {
                        required: $messages[1],
                    },
                    emp_relationship_identity_number: {
                        required: $messages[1],
                    },
                    emp_relationship_name: {
                        required: $messages[1],
                    },
                },
                errorElement: "span",
                errorPlacement: function ( error, element ) {
                    error.addClass('invalid-feedback');
                    if(element.closest('.form-group').hasClass('row')) {
                        element.closest('.form-group').find('div:first').append(error);
                    } else {
                        element.closest('.form-group').append(error);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    if(element.classList.contains('form-check-input')) {

                    } else {
                        $(element).addClass('is-invalid');
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function (form) {
                    var i = 0;
                    if($('#formEmployeeRelationship input[name="row"]').val() == '') {
                        var cloneElement = $('#table-relationship-tmp tbody tr:last').clone();
                        $('#table-relationship tbody').append(cloneElement);
                        for(var i=1; $('#employee_relationship_id'+i).length;i++){}
                        cloneElement.attr('id', 'employee-relationship'+i);
                    } else {
                        var cloneElement = $('#table-relationship #'+$('#formEmployeeRelationship input[name="row"]').val());
                    }
                    
                    var textInput = cloneElement.find('input');
                    var tdElement = cloneElement.find('td');

                    if($('#formEmployeeRelationship input[name="id"]').val() != '') {
                        textInput.eq(0).val($('#formEmployeeRelationship input[name="id"]').val());
                    } else {
                        textInput.eq(0).val('');
                    }

                    textInput.eq(1).val($('#formEmployeeRelationship select[name="emp_relationship_id"]').val());
                    textInput.eq(2).val($('#formEmployeeRelationship input[name="emp_relationship_identity_number"]').val());
                    textInput.eq(3).val($('#formEmployeeRelationship input[name="emp_relationship_name"]').val());
                    textInput.eq(4).val($('#formEmployeeRelationship input[name="emp_relationship_birth_place"]').val());
                    textInput.eq(5).val($('#formEmployeeRelationship input[name="emp_relationship_birth_date"]').val());
                    textInput.eq(6).val($('#formEmployeeRelationship input[name="emp_relationship_gender"]:checked').val());
                    textInput.eq(7).val($('#formEmployeeRelationship input[name="emp_relationship_phone"]').val());
                    textInput.eq(8).val($('#formEmployeeRelationship input[name="emp_relationship_email"]').val());
                    textInput.eq(9).val($('#formEmployeeRelationship textarea[name="emp_relationship_address"]').val());
                    tdElement.eq(1).html("<p>(" + $('#formEmployeeRelationship select[name="emp_relationship_id"] option:selected').text() + ") " + $('#formEmployeeRelationship input[name="emp_relationship_identity_number"]').val() + " " +$('#formEmployeeRelationship input[name="emp_relationship_name"]').val() + "</p>")
                    $('#modalEmployeeRelationship').modal('hide');
                }
            });
        })

        function isDefault(element) {
            if(element.checked) {
                $(element).closest(".form-check").find("input[type='hidden']").val("1");
            } else {
                $(element).closest(".form-check").find("input[type='hidden']").val("0");
            }
        }

        function removeRow(element)
        {
            $(element).closest('tr').remove();
        }

        function onSelectedCompany(data) {
            $('#company_id'+seqId).val(data[0].id);
            $('#company_name'+seqId).val(data[0].name);
        }

        function onSelectedDepartment(data) {
            $('#department_id'+seqId).val(data[0].id);
            $('#department_name'+seqId).val(data[0].name);
        }

        function onSelectedPosition(data) {
            $('#position_id'+seqId).val(data[0].id);
            $('#position_name'+seqId).val(data[0].name);
        }

        function onSelectedAttribute(data) {
            $('#attribute_id'+seqId).val(data[0].id);
            $('#attribute_name'+seqId).val(data[0].name);
        }

        // function onSelectedAfdelink(data) {
        //     $('#afdelink_id'+seqId).val(data[0].id);
        //     $('#afdelink_name'+seqId).val(data[0].name);
        // }

        function onSelectedRelationship(data) {
            $('#relationship_id'+seqId).val(data[0].id);
            $('#relationship_name'+seqId).val(data[0].name);
        }

        function onSelectedAfdelink(data) {
            $('#afdelink_id').val(data[0].id);
            $('#afdelink_name').val(data[0].name);
        }

        function viewEmployeeRelationship(element) {
            var row = $(element).closest('tr');
            var inputElement = $(row).find('input');

            $('#formEmployeeRelationship input[name="row"]').val($(row).attr('id'));
            $('#formEmployeeRelationship input[name="id"]').val(inputElement.eq(0).val());
            $('#formEmployeeRelationship select[name="emp_relationship_id"]').val(inputElement.eq(1).val());
            $('#formEmployeeRelationship input[name="emp_relationship_identity_number"]').val(inputElement.eq(2).val());
            $('#formEmployeeRelationship input[name="emp_relationship_name"]').val(inputElement.eq(3).val());
            $('#formEmployeeRelationship input[name="emp_relationship_birth_place"]').val(inputElement.eq(4).val());
            $('#formEmployeeRelationship input[name="emp_relationship_birth_date"]').val(inputElement.eq(5).val());
            $("#formEmployeeRelationship input[name='emp_relationship_gender'][value='"+inputElement.eq(6).val()+"']").prop('checked', true);
            $('#formEmployeeRelationship input[name="emp_relationship_phone"]').val(inputElement.eq(7).val());
            $('#formEmployeeRelationship input[name="emp_relationship_email"]').val(inputElement.eq(8).val());
            $('#formEmployeeRelationship textarea[name="emp_relationship_address"]').val(inputElement.eq(9).val());

            validatorEmployeeRelationship.resetForm();
            formEmployeeRelationship.find(".is-invalid").removeClass("is-invalid");
            $('#modalEmployeeRelationship').modal('show');
        }

        function onSelectedWorkUnit(data) {
            $('#work_unit_id').val(data[0].id);
            $('#work_unit_name').val(data[0].name);
        }

        function onSelectedGrade(data) {
            $('#grade_id').val(data[0].id);
            $('#grade_name').val(data[0].name);
        }
    </script>
@endsection