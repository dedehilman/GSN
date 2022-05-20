@extends('layout', ['title' => Lang::get("Menu"), 'subTitle' => Lang::get("View data menu")])

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
                        <div class="col-md-9 col-form-label">{{$data->code}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Title")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->title}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Class")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->class}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Nav Header")}}</label>
                        <div class="col-md-9 col-form-label">
                            @if ($data->nav_header == 1)
                                <span class="badge badge-primary">{{ __('Yes') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('No') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Link")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->link}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Sequence")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->sequence}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Display")}}</label>
                        <div class="col-md-9 col-form-label">
                            @if ($data->display == 1)
                                <span class="badge badge-primary">{{ __('Yes') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('No') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('menu.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection