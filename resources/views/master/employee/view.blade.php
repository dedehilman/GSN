@extends('layout', ['title' => Lang::get("Employee"), 'subTitle' => Lang::get("View data employee")])

@section('content')
    <div class="row">
        <div class="col-md-12">
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
                        <label class="col-md-3 col-form-label">{{__("Code")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->code}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Birth Place / Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->birth_place}} / {{$data->birth_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Gender")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->gender}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Identity Number")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->identity_number}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->phone}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Email")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->email}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                        <div class="col-md-9 col-form-label">{!!nl2br($data->address)!!}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Afdelink")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->afdelink->name ?? ''}}</div>
                    </div>
					<div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Business Area")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->afdelink->estate->name ?? ''}}</div>
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
                                                <th>{{ __('Company') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->companies as $company)
                                                <tr>
                                                    <td>{{$company->company->name}}</td>
                                                    <td>{{$company->effective_date}}</td>
                                                    <td>{{$company->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($company->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <table class="table table-bordered" id="table-department">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Department') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->departments as $department)
                                                <tr>
                                                    <td>{{$department->department->name}}</td>
                                                    <td>{{$department->effective_date}}</td>
                                                    <td>{{$department->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($department->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel">
                                    <table class="table table-bordered" id="table-position">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Position') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->positions as $position)
                                                <tr>
                                                    <td>{{$position->position->name}}</td>
                                                    <td>{{$position->effective_date}}</td>
                                                    <td>{{$position->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($position->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab4" role="tabpanel">
                                    <table class="table table-bordered" id="table-attribute">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Attribute') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->attributes as $attribute)
                                                <tr>
                                                    <td>{{$attribute->attribute->name}}</td>
                                                    <td>{{$attribute->effective_date}}</td>
                                                    <td>{{$attribute->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($attribute->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show active" id="tab5" role="tabpanel">
                                    <table class="table table-bordered" id="table-relationship">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Relationship') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->relationships as $idx => $relationship)
                                                <tr id="employee-relationship{{$idx}}">
                                                    <td style="cursor: pointer" onclick="viewEmployeeRelationship(this)">
                                                        <input type="hidden" name="employee_relationship_id[]" value="{{$relationship->id}}">
                                                        <input type="hidden" name="relationship_id[]" value="{{$relationship->relationship->id}}">
                                                        <input type="hidden" name="employee_identity_number[]" value="{{$relationship->identity_number}}">
                                                        <input type="hidden" name="employee_name[]" value="{{$relationship->name}}">
                                                        <input type="hidden" name="employee_birth_place[]" value="{{$relationship->birth_place}}">
                                                        <input type="hidden" name="employee_birth_date[]" value="{{$relationship->birth_date}}">
                                                        <input type="hidden" name="employee_gender[]" value="{{$relationship->gender}}">
                                                        <input type="hidden" name="employee_phone[]" value="{{$relationship->phone}}">
                                                        <input type="hidden" name="employee_email[]" value="{{$relationship->email}}">
                                                        <input type="hidden" name="employee_address[]" value="{{$relationship->address}}">
                                                        <p>
                                                            ({{$relationship->relationship->name}}) {{$relationship->identity_number}} {{$relationship->name}}
                                                        </p>                                                            
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab6" role="tabpanel">
                                    <table class="table table-bordered" id="table-afdelink">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Afdelink') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->afdelinks as $afdelink)
                                                <tr>
                                                    <td>{{$afdelink->afdelink->name}}</td>
                                                    <td>{{$afdelink->effective_date}}</td>
                                                    <td>{{$afdelink->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($afdelink->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('employee.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                    <a href="{{route('employee.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>

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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
            $('#modalEmployeeRelationship').modal('show');
        }
    </script>
@endsection