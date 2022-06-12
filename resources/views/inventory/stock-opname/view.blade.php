@extends('layout', ['title' => Lang::get("Stock Opname"), 'subTitle' => Lang::get("View data stock opname")])

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
                        <label class="col-md-3 col-form-label">{{__("Period")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->period->code}} {{$data->period->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Medicine")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->medicine->code}} {{$data->medicine->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->clinic->code}} {{$data->clinic->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Quantity")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->qty}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('stock-opname.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection