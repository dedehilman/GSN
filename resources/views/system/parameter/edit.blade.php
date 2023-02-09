@extends('layout', ['title' => Lang::get("Parameter"), 'subTitle' => Lang::get("Edit data parameter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('parameter.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Key")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="key" class="form-control required" value="{{$data->key}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Encrypted")}}</label>
                            <div class="col-md-9 col-form-label">
                                @if ($data->encrypted == 1)
                                    <span class="badge badge-primary">{{ __('Yes') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('No') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Value")}}</label>
                            <div class="col-md-9">
                                <textarea name="value" class="form-control required" rows="5">{{$data->value}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Description")}}</label>
                            <div class="col-md-9">
                                <textarea name="description" class="form-control" rows="5">{{$data->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('parameter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection