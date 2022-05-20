@extends('layout', ['title' => Lang::get("Mail History"), 'subTitle' => Lang::get("View data mail history")])

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
                        <label class="col-md-3 col-form-label">{{__("Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->created_at}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("To")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->to}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Subject")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->subject}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Body")}}</label>
                        <div class="col-md-9 col-form-label">{!!$data->body!!}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('mail-history.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection