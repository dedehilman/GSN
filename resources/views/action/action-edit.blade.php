@php
    $action = \App\Models\Action::where('model_reference_type', get_class($data))
            ->where('model_reference_id', $data->id)
            ->first();
@endphp
<div class="form-group row mt-2">
    <label class="col-md-2 col-form-label required">{{__("Action")}}</label>
    <div class="col-md-4">
        <select name="action_action" class="form-control custom-select required">
            <option value=""></option>
            <option value="Finished" @if(($action->action ?? '') == 'Finished') selected @endif>{{__("Finished")}}</option>
            <option value="Re-Medicate" @if(($action->action ?? '') == 'Re-Medicate') selected @endif>{{__("Re-Medicate")}}</option>
            <option value="Refer" @if(($action->action ?? '') == 'Refer') selected @endif>{{__("Refer")}}</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
    <div class="col-md-4">
        <textarea name="action_remark" rows="4" class="form-control">{{$action->remark ?? ''}}</textarea>
    </div>
</div>
<div class="form-group row reference  @if(($action->action ?? '') != 'Refer') d-none @endif">
    <label class="col-md-2 col-form-label required">{{__("Reference Type")}}</label>
    <div class="col-md-4">
        <select name="action_reference_type" id="action_reference_type" class="form-control custom-select required">
            <option value=""></option>
            <option value="Internal" @if(($action->reference_type ?? '') == 'Internal') selected @endif>{{__("Internal")}}</option>
            <option value="External" @if(($action->reference_type ?? '') == 'External') selected @endif>{{__("External")}}</option>
        </select>
    </div>
</div>
<div class="form-group row reference @if(($action->action ?? '') != 'Refer') d-none @endif">
    <label class="col-md-2 col-form-label required">{{__("Reference")}}</label>
    <div class="col-md-4">
        <div class="input-group">
            <input type="text" id="action_reference_name" class="form-control required" value="{{($action->reference_type ?? '') == 'Internal' ? ($action->referenceClinic->name ?? '') : ($action->reference->name ?? '')}}" readonly>
            <input type="hidden" @if(($data->reference_type ?? '') =='Internal') name="action_reference_clinic_id" @else name="action_reference_id" @endif id="action_reference_id" value="{{($action->reference_type ?? '') == 'Internal' ? ($action->referenceClinic->id ?? '') : ($action->reference->id ?? '')}}">
            <div class="input-group-append">
                <span class="input-group-text show-modal-select reference-modal-select" data-title="{{__('Reference List')}}" data-url="{{($data->reference_type ?? '') == 'Internal' ? route('clinic.select', 'queryBuilder=0') : route('reference.select')}}" data-handler="onSelectedActionReference"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<div class="form-group row remedicate @if(($action->action ?? '') != 'Re-Medicate') d-none @endif">
    <label class="col-md-2 col-form-label required">{{__("Re-Medicate Date")}}</label>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            </div>
            <input type="text" name="action_remedicate_date" id="action_remedicate_date" class="form-control required date" value="{{$action->remedicate_date ?? ''}}">
        </div>
    </div>
</div>

@section('scriptAction')
    <script>
        $(function(){
            $("select[name='action_reference_type']").on('change', function(){
                $("#action_reference_id").val("");
                $("#action_reference_name").val("");
                
                if($(this).val() == 'Internal') {
                    $(".reference-modal-select").attr("data-url", "{{route('clinic.select', 'queryBuilder=0')}}");
                    $("#action_reference_id").attr("name", "action_reference_clinic_id");
                } else {
                    $(".reference-modal-select").attr("data-url", "{{route('reference.select')}}");
                    $("#action_reference_id").attr("name", "action_reference_id");
                }
            });

            $("select[name='action_action']").on('change', function(){
                $("#action_reference_type").val("");
                $("#action_reference_id").val("");
                $("#action_reference_name").val("");
                $("#action_remedicate_date").val("");
                $(".reference").addClass("d-none");
                $(".remedicate").addClass("d-none");

                if($(this).val() == 'Re-Medicate') {
                    $(".remedicate").removeClass("d-none");
                } else if($(this).val() == 'Refer') {
                    $(".reference").removeClass("d-none");
                }
            });
        });
        function onSelectedActionReference(data) {
            $('#action_reference_id').val(data[0].id);
            $('#action_reference_name').val(data[0].name);
        }
    </script>
@endsection