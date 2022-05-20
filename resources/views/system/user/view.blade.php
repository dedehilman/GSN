@extends('layout', ['title' => Lang::get("User"), 'subTitle' => Lang::get("View data user")])

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
                        <label class="col-md-3 col-form-label">{{__("Username")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->username}}</div>
                    </div>       
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Email")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->email}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Enabled")}}</label>
                        <div class="col-md-9 col-form-label">
                            @if ($data->enabled == 1)
                                <span class="badge badge-primary">{{ __('Yes') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('No') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Role")}}</label>
                        <div class="col-md-9 col-form-label">
                            [
                            @foreach ($data->roles as $index => $role)
                                @if ($index > 0),@endif
                                {{$role->name}}
                            @endforeach
                            ]
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('user.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection