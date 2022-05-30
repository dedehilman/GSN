@extends('layout', ['title' => Lang::get("unit"), 'subTitle' => Lang::get("Edit data unit")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('unit.update', $data->id)}}" method="POST">
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
                                <input type="text" name="code" class="form-control required" value="{{$data->code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required" value="{{$data->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('unit.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection