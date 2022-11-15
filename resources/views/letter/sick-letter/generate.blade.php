<div class="modal fade" id="modal-form" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="modalForm" action="{{route('sick-letter.generate.store')}}">
                <input type="hidden" name="model_id" value="{{$data->id}}">
                <input type="hidden" name="model_type" value="{{get_class($data)}}">
                <input type="hidden" name="patient_id" value="{{$data->patient_id}}">
                <input type="hidden" name="for_relationship" value="{{$data->for_relationship}}">
                <input type="hidden" name="patient_relationship_id" value="{{$data->patient_relationship_id}}">
                <input type="hidden" name="clinic_id" value="{{$data->clinic_id}}">
                <input type="hidden" name="medical_staff_id" value="{{$data->medical_staff_id}}">
                <div class="modal-header">
                    <h4 class="modal-title">{{__("Generate Sick Letter")}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Patient")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->patient->name}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("For Relationship")}}</label>
                                <div class="col-md-8 col-form-label">
                                    @if ($data->for_relationship == 1)
                                        <span class="badge badge-primary">{{ __('Yes') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('No') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row @if($data->for_relationship == 0) d-none @endif">
                                <label class="col-md-4 col-form-label">{{__("Relationship")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->patientRelationship->name ?? ''}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction No")}}</label>
                                <div class="col-md-8 col-form-label">{{__("Auto Generate")}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction Date")}}</label>
                                <div class="col-md-8 col-form-label">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="text" name="transaction_date" class="form-control required date" value="{{$data->transaction_date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Clinic")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->clinic->name}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Medical Staff")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->medicalStaff->name}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label required">{{__("Num Of Days")}}</label>
                                <div class="col-md-8">
                                    <input type="number" name="num_of_days" class="form-control required" value="1">
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
                                            @foreach ($diagnoses ?? [] as $diagnosis)
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
                                        <input type="text" name="diagnosis_name" id="diagnosis_name" class="form-control" readonly>
                                        <input type="hidden" name="diagnosis_id" id="diagnosis_id">
                                        <div class="input-group-append">
                                            <span class="input-group-text show-modal-select" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.select')}}" data-handler="onSelectedDiagnosis"><i class="fas fa-search"></i></span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Remark")}}</label>
                                <div class="col-md-8">
                                    <textarea name="remark" rows="4" class="form-control">{{$action->remark ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="button" class="btn btn-primary" id="btn-save-modal">{{__('Generate')}}</button>
                </div>
            </form>
        </div>
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

<script>
    $(function(){
        $("#btn-save-modal").on('click', function(){
            var form = $(this).closest('form')[0];
            var data = $(form).serialize();
            $.ajax
            ({
                type: "POST",
                url: form.action,
                data: data,
                cache: false,
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function (data) {
                    $("#modal-form").modal('hide');
                    if(data.status == '200') {
                        onGeneratedSickLetter(data);
                    } else {
                        showNotification(data.status, data.message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    showNotification(500, xhr.responseJSON.message);
                },
                complete: function() {
                    $('#loader').modal('hide');
                },
            });
        })
    })

    function onSelectedDiagnosis(data) {
        $('#diagnosis_id').val(data[0].id);
        $('#diagnosis_name').val(data[0].name);
    }

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
</script>