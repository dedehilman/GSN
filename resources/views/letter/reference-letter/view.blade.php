@extends('layout', ['title' => Lang::get("Reference Letter"), 'subTitle' => Lang::get("View data reference letter")])

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
                        <label class="col-md-2 col-form-label">{{__("Transaction No")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->transaction_no}}</div>
                        <label class="col-md-2 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->clinic->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{__("Transaction Date")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->transaction_date}}</div>
                        <label class="col-md-2 col-form-label">{{__("Medical Staff")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->medicalStaff->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{__("Reference Type")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->reference_type}}</div>
                        <label class="col-md-2 col-form-label">{{__("Patient")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->patient->name}}</div>
                    </div>
                    <div class="form-group row">
                        @if ($data->reference_type == 'Internal')
                            <label class="col-md-2 col-form-label">{{__("Reference Clinic")}}</label>
                            <div class="col-md-4 col-form-label">{{$data->referenceClinic->name}}</div>
                        @else
                            <label class="col-md-2 col-form-label">{{__("Reference")}}</label>
                            <div class="col-md-4 col-form-label">{{$data->reference->name}}</div>
                        @endif
                        <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                        <div class="col-md-4 col-form-label">{!!nl2br($data->remark)!!}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('reference-letter.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                    <a href="{{route('reference-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection