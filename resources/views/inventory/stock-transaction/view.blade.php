@extends('layout', ['title' => Lang::get("Stock Transaction"), 'subTitle' => Lang::get("View data stock transaction")])

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
                        <label class="col-md-2 col-form-label">{{__("Transaction Type")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->transaction_type}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{__("Transaction Date")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->transaction_date}}</div>
                        <label class="col-md-2 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-4 col-form-label">{{$data->clinic->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                        <div class="col-md-4 col-form-label">{!!nl2br($data->remark ?? '')!!}</div>
                        @if ($data->transaction_type == 'Transfer Out')
                            <label class="col-md-2 col-form-label">{{__("New Clinic")}}</label>
                            <div class="col-md-4 col-form-label">{{$data->clinic->name ?? ''}}</div>    
                        @elseif ($data->transaction_type == 'Transfer In')
                            <label class="col-md-2 col-form-label">{{__("Reference")}}</label>
                            <div class="col-md-4 col-form-label">{{$data->reference->transaction_no ?? ''}}</div>    
                        @endif
                        
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
                                    <table class="table table-bordered" id="table-transaction-detail">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Qty') }}</th>
                                                <th>{{ __('Remark') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->details ?? [] as $index => $detail)
                                                <tr>
                                                    <td>{{$detail->medicine->name}}</td>
                                                    <td>{{$detail->qty}}</td>
                                                    <td>{{$detail->remark}}</td>
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
                    <a href="{{route('stock-transaction.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection