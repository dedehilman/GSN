@extends('layout', ['title' => Lang::get("Sick Letter"), 'subTitle' => Lang::get("Edit data sick letter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('sick-letter.update', $data->id)}}" method="POST">
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
                                    <label class="col-md-4 col-form-label">{{__("Transaction No Ref")}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="reference_transaction_no" id="reference_transaction_no" class="form-control" readonly value="{{$data->referenceTransaction()->transaction_no ?? ""}}">
                                            <input type="hidden" name="model_type" id="model_type" value="{{$data->model_type}}">
                                            <input type="hidden" name="model_id" id="model_id" value="{{$data->model_id}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Transaction List')}}" data-url="{{route('transaction.select')}}" data-handler="onSelectedReferenceTransaction"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label required">{{__("Num Of Days")}}</label>
                                    <div class="col-md-8">
                                        <input type="number" name="num_of_days" class="form-control required"value="{{$data->num_of_days}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Diagnosis")}}</label>
                                    <div class="col-md-8">
                                        <table class="table table-bordered mt-2" id="table-diganosis">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.select')}}" data-handler="onSelectedSickLetterDiagnosis"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{__('Diagnosis')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->diagnoses as $diagnosis)
                                                <tr>
                                                    <td style="vertical-align: middle; text-align: center;">
                                                        <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                                        <input type="hidden" name="diagnosis[]" value="{{$diagnosis->id}}">
                                                    </td>
                                                    <td>{{$diagnosis->code.' - '.$diagnosis->name}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <div class="input-group">
                                            <input type="text" name="diagnosis_name" id="diagnosis_name" class="form-control" readonlyvalue="{{$data->diagnosis->name ?? ''}}">
                                            <input type="hidden" name="diagnosis_id" id="diagnosis_id" value="{{$data->diagnosis->id ?? ''}}">
                                            <div class="input-group-append">
                                                <span class="input-group-text show-modal-select" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.select')}}" data-handler="onSelectedDiagnosis"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Remark")}}</label>
                                    <div class="col-md-8">
                                        <textarea name="remark" rows="4" class="form-control">{{$data->remark}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('sick-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <div class="btn-group">
                            <a href="{{route('sick-letter.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="{{route('sick-letter.download', $data->id)}}">{{__('Download')}}</a>
                                <a class="dropdown-item" href="{{route('sick-letter.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}}</a>
                                <a class="dropdown-item send-to-email" href="#" data-href="{{route('sick-letter.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}} ...</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table id="table-diagnosis-tmp" class="d-none">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" name="diagnosis[]">
                </td>
                <td></td>
            </tr>    
        </tbody>
    </table>
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
        function onSelectedDiagnosis(data) {
            $('#diagnosis_id').val(data[0].id);
            $('#diagnosis_name').val(data[0].name);
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
        $(function(){
            $("input[name='for_relationship']").on('click', function(){
                $("#patient_relationship_name").val('');
                $("#patient_relationship_id").val('');

                if($(this).is(':checked')) {
                    $(".employee-relationship").removeClass("d-none");
                } else {
                    $(".employee-relationship").addClass("d-none");
                }
            })
        })

        function onSelectedSickLetterDiagnosis(data) {
            var clonedElement = $('#table-diagnosis-tmp tbody tr:last').clone();
            $('#table-diganosis').find('tbody').append(clonedElement);
            var textInput = clonedElement.find('input');
            var td = clonedElement.find('td');
            textInput.eq(0).val(data[0].id);
            td.eq(1).html(data[0].code + " - " + data[0].name);
        }

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }
        function onSelectedReferenceTransaction(data) {
            $('#model_type').val(data[0].model_type);
            $('#model_id').val(data[0].id);
            $('#reference_transaction_no').val(data[0].transaction_no);
        }
    </script>
@endsection