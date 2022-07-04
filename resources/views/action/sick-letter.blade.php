<div class="modal fade" id="modal-form" aria-hidden="true" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__("Generate Sick Letter")}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalForm">
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
                                    <input type="number" name="num_of_days" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Diagnosis")}}</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="diagnosis_name" id="diagnosis_name" class="form-control" readonly>
                                        <input type="hidden" name="diagnosis_id" id="diagnosis_id">
                                        <div class="input-group-append">
                                            <span class="input-group-text show-modal-select" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.select')}}" data-handler="onSelectedDiagnosis"><i class="fas fa-search"></i></span>
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
                </form>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
                <button type="button" class="btn btn-primary" id="btn-save-modal">{{__('Generate')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
    })
</script>