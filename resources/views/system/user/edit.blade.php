@extends('layout', ['title' => Lang::get("User"), 'subTitle' => Lang::get("Edit data user")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('user.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Username")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="username" class="form-control required" value="{{$data->username}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Email")}}</label>
                            <div class="col-md-9">
                                <input type="email" name="email" class="form-control required" value="{{$data->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Password")}}</label>
                            <div class="col-md-9">
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Enabled")}}</label>
                            <div class="col-md-9 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enabled" value="1" @if($data->enabled == 1) checked @endif>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Role")}}</label>
                            <div class="col-md-9 pt-2">
                                @foreach ($roles as $role)
                                    @php
                                        $checked = false;
                                        foreach ($data->roles as $userRole) {
                                            if($userRole->id == $role->id) {
                                                $checked = true;
                                            }
                                        }    
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input required" type="checkbox" name="roles[]" value="{{$role->id}}" @if($checked) checked @endif>
                                        <label class="form-check-label">{{$role->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("User Detail")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" id="user_detail_name" class="form-control" readonly value="{{$data->userDetail->name ?? ''}}">
                                    <input type="hidden" name="user_detail_id" id="user_detail_id" value="{{$data->userDetail->id ?? ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('user.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedMedicalStaff(data) {
            $('#user_detail_id').val(data[0].id);
            $('#user_detail_name').val(data[0].name);
        }
    </script>
@endsection