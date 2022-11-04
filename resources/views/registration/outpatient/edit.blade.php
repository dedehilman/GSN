@extends('layout', ['title' => Lang::get("Outpatient Registration"), 'subTitle' => Lang::get("Edit data outpatient registration")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('registration.outpatient.update', $data->id)}}" method="POST">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Patient")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="patient_name" id="patient_name" class="form-control required" readonly value="{{$data->patient->name}}">
                                            <input type="hidden" name="patient_id" id="patient_id" value="{{$data->patient->id}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Patient List')}}" data-url="{{route('employee.select')}}" data-handler="onSelectedPatient"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("For Relationship")}}</label>
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="for_relationship" value="1" @if($data->for_relationship == '1') checked @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row employee-relationship @if($data->for_relationship == '0') d-none @endif">
                                    <label class="col-md-4 col-form-label required">{{__("Relationship")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="patient_relationship_name" id="patient_relationship_name" class="form-control required" readonly value="{{$data->patientRelationship->name ?? ''}}">
                                            <input type="hidden" name="patient_relationship_id" id="patient_relationship_id" value="{{$data->patientRelationship->id ?? ''}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select employee-relationship-select" data-title="{{__('Relationship List')}}" data-url="{{route('employee-relationship.select', 'employee_id='.$data->patient_id)}}" data-handler="onSelectedPatientRelationship"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Transaction No")}}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="transaction_no" class="form-control required" readonly value="{{$data->transaction_no}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Transaction Date")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" name="transaction_date" class="form-control required date" value="{{$data->transaction_date}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Reference Type")}}</label>
                                    <div class="col-md-8">
                                        <select name="reference_type" class="form-control custom-select required">
                                            <option value="Non Reference" @if($data->reference_type == 'Non Reference') selected @endif>{{__("Non Reference")}}</option>
                                            <option value="Internal" @if($data->reference_type == 'Internal') selected @endif>{{__("Internal")}}</option>
                                            <option value="External" @if($data->reference_type == 'External') selected @endif>{{__("External")}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row referenceRow {{$data->reference_type == 'Non Reference' ? 'd-none' : ''}}">
                                    <label class="col-md-4 col-form-label required">{{__("Reference")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="reference_name" class="form-control required" value="{{$data->reference_type == 'Internal' ? $data->referenceClinic->name : ($data->reference_type == 'External' ? $data->reference->name : '')}}" readonly>
                                            <input type="hidden" @if($data->reference_type=='Internal') name="reference_clinic_id" @else name="reference_id" @endif id="reference_id" value="{{$data->reference_type == 'Internal' ? $data->referenceClinic->id :  ($data->reference_type == 'External' ? $data->reference->id : '')}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select reference-modal-select" data-title="{{__('Reference List')}}" data-url="{{$data->reference_type == 'Internal' ? route('clinic.select', 'queryBuilder=0') :  $data->reference_type == 'External' ? route('reference.select') : ''}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Clinic")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="clinic_name" id="clinic_name" class="form-control required" readonly value="{{$data->clinic->name}}">
                                            <input type="hidden" name="clinic_id" id="clinic_id" value="{{$data->clinic->id}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Medical Staff")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="medical_staff_name" id="medical_staff_name" class="form-control required" readonly value="{{$data->medicalStaff->name}}">
                                            <input type="hidden" name="medical_staff_id" id="medical_staff_id" value="{{$data->medicalStaff->id}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('registration.outpatient.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <div class="btn-group">
                            <a href="{{route('registration.outpatient.download', $data->id)}}?type=queue" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="{{route('registration.outpatient.download', $data->id)}}?type=queue">{{__('Queue')}}</a>
                                <a class="dropdown-item" href="{{route('registration.outpatient.download', $data->id)}}?type=patient-identity">{{__('Patient')}}</a>
                            </div>
                        </div>
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
                $("#reference_id").val("");
                $("#reference_name").val("");
                
                if($(this).val() == 'Internal') {
                    $(".reference-modal-select").attr("data-url", "{{route('clinic.select', 'queryBuilder=0')}}");
                    $("#reference_id").attr("name", "reference_clinic_id");
                    $(".referenceRow").removeClass("d-none");
                } else if($(this).val() == 'External') {
                    $(".reference-modal-select").attr("data-url", "{{route('reference.select')}}");
                    $("#reference_id").attr("name", "reference_id");
                    $(".referenceRow").removeClass("d-none");
                } else {
                    $(".referenceRow").addClass("d-none");
                }
            });

            $("input[name='for_relationship']").on('click', function(){
                $("#patient_relationship_name").val('');
                $("#patient_relationship_id").val('');

                if($(this).is(':checked')) {
                    $(".employee-relationship").removeClass("d-none");
                } else {
                    $(".employee-relationship").addClass("d-none");
                }
            })
        });
        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
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
        function onSelectedPatientRelationship(data) {
            $('#patient_relationship_id').val(data[0].id);
            $('#patient_relationship_name').val(data[0].name);
        }
    </script>
@endsection