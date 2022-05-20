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
                        <label class="col-md-3 col-form-label">{{__("User")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->user->username}}</div>
                    </div>
                    @if(getCurrentUser()->can('employee-company-create') || getCurrentUser()->can('employee-company-edit') || getCurrentUser()->can('employee-company-list') || getCurrentUser()->can('employee-company-delete'))
                        <a href="{{route('employee.company.index', $data->id)}}">{{__('Company Information Detail')}}</a>
                    @endif
                    @if(getCurrentUser()->can('employee-department-create') || getCurrentUser()->can('employee-department-edit') || getCurrentUser()->can('employee-department-list') || getCurrentUser()->can('employee-department-delete'))
                        <a class="d-block mt-3" href="{{route('employee.department.index', $data->id)}}">{{__('Department Information Detail')}}</a>
                    @endif
                    @if(getCurrentUser()->can('employee-position-create') || getCurrentUser()->can('employee-position-edit') || getCurrentUser()->can('employee-position-list') || getCurrentUser()->can('employee-position-delete'))
                        <a class="d-block mt-3" href="{{route('employee.position.index', $data->id)}}">{{__('Position Information Detail')}}</a>
                    @endif
                    @if(getCurrentUser()->can('employee-attribute-create') || getCurrentUser()->can('employee-attribute-edit') || getCurrentUser()->can('employee-attribute-list') || getCurrentUser()->can('employee-attribute-delete'))
                        <a class="d-block mt-3" href="{{route('employee.attribute.index', $data->id)}}">{{__('Attribute Information Detail')}}</a>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('employee.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection