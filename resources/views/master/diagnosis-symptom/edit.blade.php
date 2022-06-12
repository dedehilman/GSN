@extends('layout', ['title' => Lang::get("Diagnosis Symptom"), 'subTitle' => Lang::get("Edit data diagnosis symptom")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('diagnosis-symptom.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Diagnosis")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="diagnosis_name" id="diagnosis_name" class="form-control required" value="{{$data->diagnosis->code}} {{$data->diagnosis->name}}">
                                    <input type="hidden" name="diagnosis_id" id="diagnosis_id" value="{{$data->diagnosis->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.select')}}" data-handler="onSelectedDiagnosis"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Diagnosis")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="symptom_name" id="symptom_name" class="form-control required" value="{{$data->symptom->code}} {{$data->symptom->name}}">
                                    <input type="hidden" name="symptom_id" id="symptom_id" value="{{$data->symptom->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedSymptom"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('diagnosis-symptom.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedDiagnosis(data) {
            $('#diagnosis_id').val(data[0].id);
            $('#diagnosis_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedSymptom(data) {
            $('#symptom_id').val(data[0].id);
            $('#symptom_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection