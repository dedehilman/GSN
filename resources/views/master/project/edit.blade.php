@extends('layout', ['title' => Lang::get("Client"), 'subTitle' => Lang::get("Edit data product client")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('client.update', $data->id)}}" method="POST">
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
                                <input type="text" name="fullname" class="form-control required" value="{{$data->fullname}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Email")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="email" class="form-control required" value="{{$data->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Phone")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control required" value="{{$data->phone}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Address")}}</label>
                            <div class="col-md-9">
                                <textarea name="address" id="address" class="form-control required">{{$data->address}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('client.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection