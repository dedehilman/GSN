@extends('layout', ['title' => Lang::get("Media"), 'subTitle' => Lang::get("View data media")])

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
                        <label class="col-md-3 col-form-label">{{__("File Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->file_name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Type")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->mime_type}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Size")}}</label>
                        <div class="col-md-9 col-form-label">{{formatBytes($data->size)}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Link")}}</label>
                        <div class="col-md-9 col-form-label"><a href="{{ asset("public/storage/media/".$data->id."/".$data->file_name) }}" target="_blank">{{ asset("public/storage/media/".$data->id."/".$data->file_name) }}</a></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('media.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection