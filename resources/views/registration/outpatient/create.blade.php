@extends('layout', ['title' => Lang::get("Outpatient Registration"), 'subTitle' => Lang::get("Create data outpatient registration")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('registration.outpatient.store')}}" method="POST">
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
                                    <label class="col-md-3 col-form-label">
                                        {{__("Search Patient")}}
                                        <span class="ml-2 show-modal-select" data-title="{{__('Patient List')}}" data-url="{{route('employee.select')}}" data-handler="onSelectedPatient"><i class="fas fa-search text-primary"></i></span>
                                        <input type="hidden" name="patient_id" id="patient_id">
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__("Code")}}</label>
                                    <div class="col-md-9 col-form-label" id="patient_code">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                                    <div class="col-md-9 col-form-label" id="patient_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__("Birth Place / Date")}}</label>
                                    <div class="col-md-9 col-form-label" id="patient_birth">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__("Gender / Old")}}</label>
                                    <div class="col-md-9 col-form-label" id="patient_gender">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                                    <div class="col-md-9 col-form-label" id="patient_address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label required">{{__("Transaction No")}}</label>
                                    <div class="col-md-9">
                                        <input type="text" name="registration_no" class="form-control required" readonly value="{{__('Auto Generate')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label required">{{__("Transaction Date")}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="text" name="registration_date" class="form-control required date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label required">{{__("Reference")}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" name="reference_name" id="reference_name" class="form-control required">
                                            <input type="hidden" name="reference_id" id="reference_id">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Reference List')}}" data-url="{{route('reference.select')}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label required">{{__("Clinic")}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" name="clinic_name" id="clinic_name" class="form-control required">
                                            <input type="hidden" name="clinic_id" id="clinic_id">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label required">{{__("Medical Staff")}}</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" name="medical_staff_name" id="medical_staff_name" class="form-control required">
                                            <input type="hidden" name="medical_staff_id" id="medical_staff_id">
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
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedReference(data) {
            $('#reference_id').val(data[0].id);
            $('#reference_name').val(data[0].name);
        }
        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
        }
        function onSelectedMedicalStaff(data) {
            $('#medical_staff_id').val(data[0].id);
            $('#medical_staff_name').val(data[0].name);
        }
        function onSelectedPatient(data) {
            $('#patient_id').val(data[0].id);
            $('#patient_code').text(data[0].code);
            $('#patient_name').text(data[0].name);
            $('#patient_birth').text(data[0].birth_place + " / " + data[0].birth_date);
            $('#patient_gender').text(data[0].gender + " / 10");
            $('#patient_address').text(data[0].address);
        }
    </script>
@endsection