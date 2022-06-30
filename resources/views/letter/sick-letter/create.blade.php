@extends('layout', ['title' => Lang::get("Sick Letter"), 'subTitle' => Lang::get("Create data sick letter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('sick-letter.store')}}" method="POST">
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
                                <input type="text" name="transaction_no" class="form-control required" readonly value="{{__('Auto Generate')}}">
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Clinic")}}</label>
                            <div class="col-md-4">
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
                            <label class="col-md-2 col-form-label required">{{__("Transaction Date")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="transaction_date" class="form-control required date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
                                </div>
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Medical Staff")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="medical_staff_name" id="medical_staff_name" class="form-control required">
                                    <input type="hidden" name="medical_staff_id" id="medical_staff_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">{{__("Num Of Days")}}</label>
                            <div class="col-md-4">
                                <input type="number" name="num_of_days" class="form-control required">
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Patient")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="patient_name" id="patient_name" class="form-control required">
                                    <input type="hidden" name="patient_id" id="patient_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Patient List')}}" data-url="{{route('employee.select')}}" data-handler="onSelectedPatient"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                            <div class="col-md-4">
                                <textarea name="remark" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('sick-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
            $('#patient_name').val(data[0].name);
        }
    </script>
@endsection