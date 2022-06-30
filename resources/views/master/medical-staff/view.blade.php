@extends('layout', ['title' => Lang::get("Medical Staff"), 'subTitle' => Lang::get("View data medical-staff")])

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
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Gender")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->gender}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->phone}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Email")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->email}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                        <div class="col-md-9 col-form-label">{!!nl2br($data->address)!!}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Clinic") }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" style="padding-top: 10px">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <table class="table table-bordered" id="table-clinic">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Clinic') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->clinics as $clinic)
                                                <tr>
                                                    <td>{{$clinic->clinic->name}}</td>
                                                    <td>{{$clinic->effective_date}}</td>
                                                    <td>{{$clinic->expiry_date}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('medical-staff.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection