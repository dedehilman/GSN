@extends('layout', ['title' => Lang::get("Sequence Period"), 'subTitle' => Lang::get("View data sequence period")])

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
                        <label class="col-md-3 col-form-label">{{__("Effective Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->effective_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Expiry Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->expiry_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Number Next")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->number_next}}</div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('sequence.period.index', ["parentId"=>$data->sequence_id])}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection