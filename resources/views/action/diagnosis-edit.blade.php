@php
    $diagnoses = \App\Models\DiagnosisResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
    $symptoms = \App\Models\SymptomResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<table class="table table-bordered mt-2" id="table-symptom">
    <thead>
        <tr>
            <th width="10px" class="text-center">
                <span class='btn btn-primary btn-sm' id="btn-add-symptom" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
            </th>
            <th>{{__('Symptom')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($symptoms as $index => $symptom)
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" value="{{$index}}">
                    <input type="hidden" name="result_symptom_id[]" id="result_symptom_id{{$index}}" value="{{$symptom->id}}">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" id="symptom_name{{$index}}" readonly value="{{$symptom->symptom->name}}">
                        <input type="hidden" id="symptom_id{{$index}}" name="symptom_id[]" value="{{$symptom->symptom->id}}">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedResultSymptom"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>
<table class="table table-bordered mt-2" id="table-diagnosis">
    <thead>
        <tr>
            <th width="10px" class="text-center">
                <span class='btn btn-primary btn-sm' id="btn-add-diagnosis" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
            </th>
            <th>{{__('Diagnosis')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($diagnoses as $index => $diagnosis)
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" value="{{$index}}">
                    <input type="hidden" name="result_diagnosis_id[]" id="result_diagnosis_id{{$index}}" value="{{$diagnosis->id}}">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control" id="diagnosis_name{{$index}}" readonly value="{{$diagnosis->diagnosis->name}}">
                        <input type="hidden" id="diagnosis_id{{$index}}" name="diagnosis_id[]" value="{{$diagnosis->diagnosis->id}}">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select-custom" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.calculate')}}" data-handler="onSelectedResultDiagnosis"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>

<table class="d-none" id="table-symptom-tmp">
    <tbody>
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                <input type="hidden">
                <input type="hidden">
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control" readonly>
                    <input type="hidden">
                    <div class="input-group-append">
                        <span class="input-group-text show-modal-select" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedResultSymptom"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table class="d-none" id="table-diagnosis-tmp">
    <tbody>
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                <input type="hidden">
                <input type="hidden">
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control" readonly>
                    <input type="hidden">
                    <div class="input-group-append">
                        <span class="input-group-text show-modal-select-custom" data-title="{{__('Diagnosis List')}}" data-url="{{route('diagnosis.calculate')}}" data-handler="onSelectedResultDiagnosis"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

@section('scriptDiagnosis')
    <script>
        function onSelectedResultSymptom(data) {
            $('#symptom_id'+seqId).val(data[0].id);
            $('#symptom_name'+seqId).val(data[0].name);
        }

        function onSelectedResultDiagnosis(data) {
            console.log(data);
            $('#diagnosis_id'+seqId).val(data[0].id);
            $('#diagnosis_name'+seqId).val(data[0].name);
        }

        $(function(){
            $('#btn-add-symptom').on('click', function(){
                var clonedRow = $('#table-symptom-tmp tbody tr:last').clone();
                $('#table-symptom tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#result_symptom_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'result_symptom_id' + i);
                textInput.eq(2).attr('id', 'symptom_name' + i);
                textInput.eq(3).attr('id', 'symptom_id' + i);
                textInput.eq(1).attr('name', 'result_symptom_id[]');
                textInput.eq(3).attr('name', 'symptom_id[]');
                textInput.val('');
                textInput.eq(0).val(i);
            });

            $('#btn-add-diagnosis').on('click', function(){
                var clonedRow = $('#table-diagnosis-tmp tbody tr:last').clone();
                $('#table-diagnosis tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#result_diagnosis_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'result_diagnosis_id' + i);
                textInput.eq(2).attr('id', 'diagnosis_name' + i);
                textInput.eq(3).attr('id', 'diagnosis_id' + i);
                textInput.eq(1).attr('name', 'result_diagnosis_id[]');
                textInput.eq(3).attr('name', 'diagnosis_id[]');
                textInput.val('');
                textInput.eq(0).val(i);
            });

            $(document).on('click', '.show-modal-select', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });
            
            $(document).on('click', '.show-modal-select-custom', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });

            $(document).on('click', '.show-modal-select-custom', function(){
                setSelectedIds();
                onSelectHandler = $(this).attr('data-handler');
                $('#modal-select .modal-title').html($(this).attr('data-title'));
                symptomIds = "";
                $("input[name^=symptom_id]").each(function(index, element){
                    if($(element).val() != "" && $(element).attr("id") != undefined) {
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
    </script>
@endsection