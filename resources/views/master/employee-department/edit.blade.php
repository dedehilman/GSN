@extends('layout', ['title' => Lang::get("Employee Department"), 'subTitle' => Lang::get("Edit data employee department")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('employee.department.update', ["parentId"=>$data->employee_id, "department"=>$data->id])}}" method="POST">
                @csrf
                <input type="hidden" name="employee_id" value="{{$data->employee_id}}">

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
                            <label class="col-md-3 col-form-label required">{{__("Effective Date")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="effective_date" class="form-control required date" value="{{$data->effective_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Expiry Date")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="expiry_date" class="form-control date" value="{{$data->expiry_date}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Department")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="department_name" id="department_name" class="form-control required" value="{{$data->department->name}}">
                                    <input type="hidden" name="department_id" id="department_id" value="{{$data->department_id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Department List')}}" data-url="{{route('department.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Default")}}</label>
                            <div class="col-md-9 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" value="1" @if($data->is_default==1)checked @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('employee.department.index', ["parentId"=>$data->employee_id])}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelected(data) {
            $('#department_id').val(data[0].id);
            $('#department_name').val(data[0].name);
        }
    </script>
@endsection