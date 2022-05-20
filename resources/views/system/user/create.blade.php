@extends('layout', ['title' => Lang::get("User"), 'subTitle' => Lang::get("Create data user")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('user.store')}}" method="POST">
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
                                <input type="text" name="name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Username")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="username" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Email")}}</label>
                            <div class="col-md-9">
                                <input type="email" name="email" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Password")}}</label>
                            <div class="col-md-9">
                                <input type="password" name="password" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Enabled")}}</label>
                            <div class="col-md-9 pt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enabled" value="1" checked>                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Role")}}</label>
                            <div class="col-md-9 pt-2">
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input required" type="checkbox" name="roles[]" value="{{$role->id}}">
                                        <label class="form-check-label">{{$role->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('user.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection