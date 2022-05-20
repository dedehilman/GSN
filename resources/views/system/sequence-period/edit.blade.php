@extends('layout', ['title' => Lang::get("Sequence Period"), 'subTitle' => Lang::get("Edit data sequence period")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('sequence.period.update', ["parentId"=>$data->sequence_id, "period"=>$data->id])}}" method="POST">
                @csrf
                <input type="hidden" name="sequence_id" value="{{$data->sequence_id}}">

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
                            <label class="col-md-3 col-form-label required">{{__("Effective Date")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="effective_date" class="form-control required date" value="{{$data->effective_date}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Expiry Date")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="expiry_date" class="form-control required date" value="{{$data->expiry_date}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Number Next")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="number_next" class="form-control required" value="{{$data->number_next}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('sequence.period.index', ["parentId"=>$data->sequence_id])}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection