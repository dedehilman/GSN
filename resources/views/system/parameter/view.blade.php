@extends('layout', ['title' => Lang::get("Parameter"), 'subTitle' => Lang::get("View data parameter")])

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
                        <label class="col-md-3 col-form-label">{{__("Key")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->key}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Value")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->value}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Description")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->description}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('parameter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection