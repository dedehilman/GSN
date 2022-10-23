@extends('layout', ['title' => Lang::get("Stock Opname Uploader"), 'subTitle' => Lang::get("View data stock opname uploader")])

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
                        <label class="col-md-3 col-form-label">{{__("Number")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->upl_line_no}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Status")}}</label>
                        <div class="col-md-5 col-form-label">
                            @if ($data->upl_status == 0)
                                <span class="badge badge-primary">{{__('Raw')}}</span>
                            @elseif ($data->upl_status == 1)
                                <span class="badge badge-success">{{__('Valid')}}</span>
                            @elseif ($data->upl_status == 2)
                                <span class="badge badge-danger">{{__('Invalid')}}</span>
                            @elseif ($data->upl_status == 3)
                                <span class="badge badge-danger">{{__('Failed')}}</span>
                            @else
                                <span class="badge badge-success">{{__('Commited')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Remark")}}</label>
                        <div class="col-md-5 col-form-label">{!!nl2br($data->upl_remark)!!}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Period")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->period}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Medicine")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->medicine}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->clinic}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Qty")}}</label>
                        <div class="col-md-5 col-form-label">{{$data->qty}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('stock-opname.uploader.index', ["uplNo"=>$data->upl_no])}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection