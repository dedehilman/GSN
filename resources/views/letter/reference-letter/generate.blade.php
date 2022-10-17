<div class="modal fade" id="modal-form" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="modalForm" action="{{route('reference-letter.generate.store')}}">
                <input type="hidden" name="model_id" value="{{$data->id}}">
                <input type="hidden" name="model_type" value="{{get_class($data)}}">
                <input type="hidden" name="patient_id" value="{{$data->patient_id}}">
                <input type="hidden" name="for_relationship" value="{{$data->for_relationship}}">
                <input type="hidden" name="patient_relationship_id" value="{{$data->patient_relationship_id}}">
                <input type="hidden" name="clinic_id" value="{{$data->clinic_id}}">
                <input type="hidden" name="medical_staff_id" value="{{$data->medical_staff_id}}">
                <div class="modal-header">
                    <h4 class="modal-title">{{__("Generate Reference Letter")}}</h4>
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
                                <label class="col-md-4 col-form-label">{{__("Reference Type")}}</label>
                                <div class="col-md-8">
                                    <select name="reference_type" class="form-control custom-select required">
                                        <option value=""></option>
                                        <option value="Internal" @if(($action->reference_type ?? '') == 'Internal') selected @endif>{{__("Internal")}}</option>
                                        <option value="External" @if(($action->reference_type ?? '') == 'External') selected @endif>{{__("External")}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Reference")}}</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="reference_name" class="form-control required" value="{{($action->reference_type ?? '') == 'Internal' ? ($action->referenceClinic->name ?? '') : ($action->reference->name ?? '')}}" readonly>
                                        <input type="hidden" @if(($action->reference_type ?? '') =='Internal') name="reference_clinic_id" @else name="reference_id" @endif id="reference_id" value="{{($data->reference_type ?? '') == 'Internal' ? ($data->referenceClinic->id ?? '') : ($data->reference->id ?? '')}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text show-modal-select reference-modal-select" data-title="{{__('Reference List')}}" data-url="{{($data->reference_type ?? '') == 'Internal' ? route('clinic.select', 'queryBuilder=0') : route('reference.select')}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                        </div>
                                    </div>
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
                    if(data.status == '200') {
                        $("#modal-form").modal('hide');
                        onGeneratedReferenceLetter(data);
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
    });
    function onSelectedReference(data) {
        $('#reference_id').val(data[0].id);
        $('#reference_name').val(data[0].name);
    }
</script>