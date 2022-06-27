@if (isMultipleClinic())
    <div class="input-group">
        <input type="text" id="clinic_name" class="form-control required" value="{{$clinic ?? null != null ? $clinic->code.' '.$clinic->name : ''}}">
        <input type="hidden" name="clinic_id" id="clinic_id" value="{{$clinic ?? null != null ? $clinic->id : ''}}">
        <div class="input-group-append">
            <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
        </div>
    </div>
@else
    <div class="col-form-label">
        {{$clinic ?? null != null ? $clinic->code.' '.$clinic->name : (getDefaultClinic()->code ?? '').' '.(getDefaultClinic()->name ?? '')}}
        <input type="hidden" name="clinic_id" value="{{$clinic ?? null != null ? $clinic->id : getDefaultClinic()->id ?? ''}}">    
    </div>
@endif

<script>
    function onSelectedClinic(data) {
        $('#clinic_id').val(data[0].id);
        $('#clinic_name').val(data[0].code + ' ' + data[0].name);
    }
</script>