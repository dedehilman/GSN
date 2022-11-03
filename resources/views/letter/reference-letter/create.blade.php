@extends('layout', ['title' => Lang::get("Reference Letter"), 'subTitle' => Lang::get("Create data reference letter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('reference-letter.store')}}" method="POST">
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
                                            <input type="text" name="patient_name" id="patient_name" class="form-control required" readonly>
                                            <input type="hidden" name="patient_id" id="patient_id">
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
                                            <input class="form-check-input" type="checkbox" name="for_relationship" value="1">                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row employee-relationship d-none">
                                    <label class="col-md-4 col-form-label required">{{__("Relationship")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="patient_relationship_name" id="patient_relationship_name" class="form-control required" readonly>
                                            <input type="hidden" name="patient_relationship_id" id="patient_relationship_id">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select employee-relationship-select" data-title="{{__('Relationship List')}}" data-url="{{route('employee-relationship.select', 'employee_id=0')}}" data-handler="onSelectedPatientRelationship"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Transaction No")}}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="transaction_no" class="form-control required" readonly value="{{__('Auto Generate')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Transaction Date")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" name="transaction_date" class="form-control required date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Clinic")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="clinic_name" id="clinic_name" class="form-control required" readonly>
                                            <input type="hidden" name="clinic_id" id="clinic_id">
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
                                            <input type="text" name="medical_staff_name" id="medical_staff_name" class="form-control required" readonly>
                                            <input type="hidden" name="medical_staff_id" id="medical_staff_id">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Reference Type")}}</label>
                                    <div class="col-md-8">
                                        <select name="reference_type" class="form-control custom-select required">
                                            <option value=""></option>
                                            <option value="Internal">{{__("Internal")}}</option>
                                            <option value="External">{{__("External")}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Reference")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" id="reference_name" class="form-control required" readonly>
                                            <input type="hidden" name="reference_id" id="reference_id">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select reference-modal-select" data-title="{{__('Reference List')}}" data-url="{{route('reference.select')}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Physical Check")}}</label>
                                    <div class="col-md-8">
                                        <textarea name="physical_check" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Therapy")}}</label>
                                    <div class="col-md-8">
                                        <textarea name="therapy" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Remark")}}</label>
                                    <div class="col-md-8">
                                        <textarea name="remark" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('reference-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
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
                } else {
                    $(".reference-modal-select").attr("data-url", "{{route('reference.select')}}");
                    $("#reference_id").attr("name", "reference_id");
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

            dataUrl = $('.employee-relationship-select').attr('data-url');
            if(dataUrl.indexOf("?") >= 0) {
                dataUrl = dataUrl.substring(0, dataUrl.indexOf("?"));
            }
            $('.employee-relationship-select').attr('data-url', dataUrl+"?employee_id="+data[0].id);
        }
        function onSelectedPatientRelationship(data) {
            $('#patient_relationship_id').val(data[0].id);
            $('#patient_relationship_name').val(data[0].name);
        }
    </script>
@endsection