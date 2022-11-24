@extends('layout', ['title' => Lang::get("Pharmacy"), 'subTitle' => Lang::get("View data pharmacy")])

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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction No")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->transaction_no}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction Date")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->transaction_date}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Remark")}}</label>
                                <div class="col-md-8 col-form-label">{!!nl2br($data->remark ?? '')!!}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction No Ref")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->referenceTransaction()->transaction_no ?? ""}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Clinic")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->clinic->name}}</div>
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Detail") }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" style="padding-top: 10px">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <table class="table table-bordered" id="table-pharmacy-detail">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Rule') }}</th>
                                                <th>{{ __('Stock Qty') }}</th>
                                                <th>{{ __('Qty') }}</th>
                                                <th>{{ __('Actual Qty') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->details ?? [] as $index => $detail)
                                                <tr>
                                                    <td>{{$detail->medicine->name}}</td>
                                                    <td>{{$detail->medicineRule->name}}</td>
                                                    <td>{{$detail->stock_qty}}</td>
                                                    <td>{{$detail->qty}}</td>
                                                    <td>{{$detail->actual_qty}}</td>
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
                    <a href="{{route('pharmacy.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                    @if (hasPermission("pharmacy-draft") && $data->status == "Publish")
                    <a href="{{route('pharmacy.draft', $data->id)}}" class="btn btn-primary"><i class="fas fa fa-edit"></i> {{__("Set To Draft")}}</a>                                                
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection