@extends('layout', ['title' => Lang::get("Reference Letter"), 'subTitle' => Lang::get("Edit data reference letter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('reference-letter.update', $data->id)}}" method="POST">
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
                            <label class="col-md-2 col-form-label required">{{__("Transaction No")}}</label>
                            <div class="col-md-4">
                                <input type="text" name="transaction_no" class="form-control required" readonly value="{{$data->transaction_no}}">
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Clinic")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="clinic_name" id="clinic_name" class="form-control required" value="{{$data->clinic->name}}">
                                    <input type="hidden" name="clinic_id" id="clinic_id" value="{{$data->clinic->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">{{__("Transaction Date")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="transaction_date" class="form-control required date" value="{{$data->transaction_date}}">
                                </div>
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Medical Staff")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="medical_staff_name" id="medical_staff_name" class="form-control required" value="{{$data->medicalStaff->name}}">
                                    <input type="hidden" name="medical_staff_id" id="medical_staff_id" value="{{$data->medicalStaff->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">{{__("Reference Type")}}</label>
                            <div class="col-md-4">
                                <select name="reference_type" class="form-control custom-select required">
                                    <option value=""></option>
                                    <option value="Internal" @if($data->reference_type == 'Internal') selected @endif>{{__("Internal")}}</option>
                                    <option value="External" @if($data->reference_type == 'External') selected @endif>{{__("External")}}</option>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Patient")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="patient_name" id="patient_name" class="form-control required" value="{{$data->patient->name}}">
                                    <input type="hidden" name="patient_id" id="patient_id" value="{{$data->patient->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Patient List')}}" data-url="{{route('employee.select')}}" data-handler="onSelectedPatient"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required reference @if($data->reference_type=='Internal') d-none @endif">{{__("Reference")}}</label>
                            <div class="col-md-4 reference @if($data->reference_type=='Internal') d-none @endif">
                                <div class="input-group">
                                    <input type="text" name="reference_name" id="reference_name" class="form-control required" value="{{$data->reference->name ?? ''}}">
                                    <input type="hidden" name="reference_id" id="reference_id" value="{{$data->reference->id ?? ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Reference List')}}" data-url="{{route('reference.select')}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <label class="col-md-2 col-form-label required reference-clinic @if($data->reference_type=='External') d-none @endif">{{__("Reference Clinic")}}</label>
                            <div class="col-md-4 reference-clinic @if($data->reference_type=='External') d-none @endif">
                                <div class="input-group">
                                    <input type="text" name="reference_clinic_name" id="reference_clinic_name" class="form-control required" value="{{$data->referenceClinic->name ?? ''}}">
                                    <input type="hidden" name="reference_clinic_id" id="reference_clinic_id" value="{{$data->referenceClinic->id ?? ''}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedReferenceClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Remark")}}</label>
                            <div class="col-md-4">
                                <textarea name="remark" rows="4" class="form-control">{{$data->remark}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('reference-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $("select[name='reference_type']").on('change', function(){
                $("#reference_clinic_id").val("");
                $("#reference_clinic_name").val("");
                $("#reference_id").val("");
                $("#reference_name").val("");

                if($(this).val() == 'Internal') {
                    $(".reference").addClass('d-none');
                    $(".reference-clinic").removeClass('d-none');
                } else {
                    $(".reference").removeClass('d-none');
                    $(".reference-clinic").addClass('d-none');
                }
            });
        });
        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
        }
        function onSelectedReferenceClinic(data) {
            $('#reference_clinic_id').val(data[0].id);
            $('#reference_clinic_name').val(data[0].name);
        }
        function onSelectedReference(data) {
            $('#reference_id').val(data[0].id);
            $('#reference_name').val(data[0].name);
        }
        function onSelectedMedicalStaff(data) {
            $('#medical_staff_id').val(data[0].id);
            $('#medical_staff_name').val(data[0].name);
        }
        function onSelectedPatient(data) {
            $('#patient_id').val(data[0].id);
            $('#patient_name').val(data[0].name);
        }
    </script>
@endsection