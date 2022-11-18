@extends('layout', ['title' => Lang::get("Job"), 'subTitle' => Lang::get("View data job")])

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
                        <label class="col-md-3 col-form-label">{{__("Queue")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->queue}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Payload")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->payload}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Attempts")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->attempts}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Reserved At")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->reserved_at}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Available At")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->available_at}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('job.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection