@extends('layout', ['title' => Lang::get("Plano Test"), 'subTitle' => Lang::get("View data sick letter report")])

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
                        <div class="col-md-5 col-form-label">{{$data->code}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Runned At")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->runned_at}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Finished At")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->finished_at}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Message")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->message}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Num Of Downloaded")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->num_of_downloaded}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Status")}}</label>
                        <div class="col-md-5 col-form-label">
                            @if ($data->status == 1)
                                <span class="badge badge-warning">{{__('On Progress')}}</span>
                            @elseif ($data->status == 2)
                                <span class="badge badge-success">{{__('Completed')}}</span>
                            @elseif ($data->status == 3)
                                <span class="badge badge-danger">{{__('Failed')}}</span>
                            @else
                                <span class="badge badge-primary">{{__('Draft')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->clinic->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Start Date")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->start_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("End Date")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->end_date}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    @if($data->status == 2)
                        <a href="{{route('report.plano-test.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                    @endif
                    <a href="{{route('report.plano-test.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection