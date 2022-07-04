@php
    $action = \App\Models\Action::where('model_reference_type', get_class($data))
            ->where('model_reference_id', $data->id)
            ->first();
@endphp
<div class="form-group row mt-2">
    <label class="col-md-2 col-form-label ">{{__("Action")}}</label>
    <div class="col-md-4 col-form-label">{{$action->action ?? ''}}</div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
    <div class="col-md-4 col-form-label">{!!nl2br($action->remark) ?? ''!!}</div>
</div>
<div class="form-group row reference @if(($action->action ?? '') != 'Refer') d-none @endif">
    <label class="col-md-2 col-form-label ">{{__("Reference Type")}}</label>
    <div class="col-md-4 col-form-label">{{$action->reference_type ?? ''}}</div>
</div>
<div class="form-group row reference @if(($action->action ?? '') != 'Refer') d-none @endif">
    <label class="col-md-2 col-form-label ">{{__("Reference")}}</label>
    <div class="col-md-4 col-form-label">{{($action->reference_type ?? '') == 'Internal' ? $action->referenceClinic->name ?? '' : $action->reference->name ?? ''}}</div>
</div>
<div class="form-group row remedicate @if(($action->action ?? '') != 'Re-Medicate') d-none @endif">
    <label class="col-md-2 col-form-label ">{{__("Re-Medicate Date")}}</label>
    <div class="col-md-4 col-form-label">{{$action->remedicate_date ?? ''}}</div>
</div>