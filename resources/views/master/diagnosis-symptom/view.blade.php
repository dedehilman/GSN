@extends('layout', ['title' => Lang::get("Diagnosis Symptom"), 'subTitle' => Lang::get("View data diagnosis symptom")])

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
                        <label class="col-md-3 col-form-label">{{__("Diagnosis")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->diagnosis->code}} {{$data->diagnosis->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Symptom")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->symptom->code}} {{$data->symptom->name}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('diagnosis-symptom.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection