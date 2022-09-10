@php
    $diagnoses = \App\Models\DiagnosisResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<button class="btn btn-default mb-2" type="button" id="btn-add-diagnosis">{{__("Add Diagnosis")}}</button>
<div id="diagnosis-cards" class="pt-2">
    @foreach ($diagnoses as $diagnosis)
        <div class="card" id="diagnosis-card{{$diagnosis->id}}">
            <div class="card-header">
                <h2 class="card-title">{{$diagnosis->diagnosis->code.' - '.$diagnosis->diagnosis->name}}</h2>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="removeCard(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label required">{{__("Diagnosis")}}</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="hidden" name="diagnosis_result_id[]" value="{{$diagnosis->id}}">
                            <input type="text" class="form-control" id="diagnosis_result_diagnosis_name{{$diagnosis->id}}" readonly value="{{$diagnosis->diagnosis->code.' - '.$diagnosis->diagnosis->name}}">
                            <input type="hidden" id="diagnosis_result_diagnosis_id{{$diagnosis->id}}" name="diagnosis_result_diagnosis_id[]" value="{{$diagnosis->diagnosis->id}}">
                            <div class="input-group-append">
                                <span class="input-group-text show-modal-select-custom" style="cursor: pointer" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.calculate')}}" data-handler="onSelectedResultDiagnosis"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label required">{{__("Symptom")}}</label>
                    <div class="col-md-10">
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th width="10px" class="text-center">
                                        <span class='btn btn-primary btn-sm show-modal-select-custom' style="cursor: pointer" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedResultSymptom"><i class='fas fa-plus-circle'></i></span>
                                    </th>
                                    <th>{{__('Symptom')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diagnosis->symptoms as $symptom)                                
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                            <input type="hidden" class="diagnosis_symptom_id" name="diagnosis_symptom_id{{$diagnosis->id}}[]" value="{{$symptom->id}}">
                                        </td>
                                        <td>{{$symptom->code.' - '.$symptom->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card d-none" id="diagnosis-card-tmp">
    <div class="card-header">
        <h2 class="card-title"></h2>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" onclick="removeCard(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-2 col-form-label required">{{__("Diagnosis")}}</label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="hidden">
                    <input type="text" class="form-control" readonly>
                    <input type="hidden">
                    <div class="input-group-append">
                        <span class="input-group-text show-modal-select-custom" style="cursor: pointer" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.calculate')}}" data-handler="onSelectedResultDiagnosis"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label required">{{__("Symptom")}}</label>
            <div class="col-md-10">
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th width="10px" class="text-center">
                                <span class='btn btn-primary btn-sm show-modal-select-custom' style="cursor: pointer" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedResultSymptom"><i class='fas fa-plus-circle'></i></span>
                            </th>
                            <th>{{__('Symptom')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<table id="table-symptom-tmp" class="d-none">
    <tbody>
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                <input type="hidden" class="diagnosis_symptom_id">
            </td>
            <td></td>
        </tr>    
    </tbody>
</table>

@section('scriptDiagnosis')
    <script>
        function onSelectedResultSymptom(data) {
            var clonedElement = $('#table-symptom-tmp tbody tr:last').clone();
            $('#diagnosis-card' + seqId).find('tbody').append(clonedElement);
            var textInput = clonedElement.find('input');
            var td = clonedElement.find('td');
            var id = $('#diagnosis-card' + seqId).find('input[name^=diagnosis_result_id]').val();
            textInput.eq(0).attr('name', 'diagnosis_symptom_id'+id+'[]');
            textInput.eq(0).val(data[0].id);
            td.eq(1).html(data[0].code + " - " + data[0].name);

            $('#diagnosis-card' + seqId).find('input[id^=diagnosis_result_diagnosis_id]').val('');
            $('#diagnosis-card' + seqId).find('input[id^=diagnosis_result_diagnosis_name]').val('');
        }

        function onSelectedResultDiagnosis(data) {
            $('#diagnosis_result_diagnosis_id'+seqId).val(data[0].id);
            $('#diagnosis_result_diagnosis_name'+seqId).val(data[0].code + " - " + data[0].name);
        }

        $(function(){
            $('#btn-add-diagnosis').on('click', function(){
                var i = 0;
                for(var i=1; $('#diagnosis_result_idn'+i).length;i++){}

                var clonedElement = $('#diagnosis-card-tmp').clone();
                clonedElement.attr('id', 'diagnosis-cardn'+i)
                $('#diagnosis-cards').append(clonedElement.removeClass("d-none"));
                var textInput = clonedElement.find('input');                
                textInput.eq(0).val('n'+i);
                textInput.eq(0).attr('id', 'diagnosis_result_idn'+i);
                textInput.eq(0).attr('name', 'diagnosis_result_id[]');
                textInput.eq(1).attr('id', 'diagnosis_result_diagnosis_namen'+i);
                textInput.eq(2).attr('id', 'diagnosis_result_diagnosis_idn'+i);
                textInput.eq(2).attr('name', 'diagnosis_result_diagnosis_id[]');
            });

            $(document).on('click', '.show-modal-select-custom', function(){
                onSelectHandler = $(this).attr('data-handler');
                seqId = $(this).closest('.card-body').find('input:first').val();
                $('#modal-select .modal-title').html($(this).attr('data-title'));
                symptomIds = "";
                $(this).closest(".card-body").find(".diagnosis_symptom_id").each(function(index, element){
                    if($(element).val() != "") {
                        if(symptomIds != "") {
                            symptomIds = symptomIds + "," + $(element).val()
                        } else {
                            symptomIds = $(element).val();
                        }
                    }
                });
                $.ajax
                ({
                    type: "GET",
                    url: $(this).attr('data-url')+"?symptom_id="+symptomIds,
                    cache: false,
                    beforeSend: function() {
                        $('#loader').modal('show');
                    },
                    success: function (data) {
                        $('#modal-select .modal-body').html(data);
                        $('#modal-select').modal('show');
                    },
                    complete: function() {
                        $('#loader').modal('hide');
                    },
                });
            })
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }

        function removeCard(element) {
            $(element).closest('.card').remove();
        }
    </script>
@endsection