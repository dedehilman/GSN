@php
    $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
    $referenceLetter = \App\Models\ReferenceLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
    $action = \App\Models\Action::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
@endphp
<p class="mt-2 sick-letter">
    @if($sickLetter) <a href="{{route('sick-letter.show', $sickLetter->id ?? '')}}">{{$sickLetter->transaction_no}}</a> @else <a href="#" class="show-modal-form-custom" data-url="{{route('sick-letter.generate', 'model_id='.$data->id."&model_type=".get_class($data))}}">{{__("Generate Sick Letter")}}</a> @endif
</p>
<p class="reference-letter {{($action->action ?? "") != "Refer" ? "d-none" : ""}}">
    @if($referenceLetter) 
        <a href="{{route('reference-letter.show', $referenceLetter->id ?? '')}}">{{$referenceLetter->transaction_no}}</a> 
    @else 
        <a href="#" class="show-modal-form-custom2" data-url="{{route('reference-letter.generate', 'model_id='.$data->id."&model_type=".get_class($data))}}">{{__("Generate Reference Letter")}}</a> 
    @endif
</p>

@section('scriptOther')
    <script>
        $(function(){

            $(document).on('click', '.show-modal-form-custom', function(){
                diagnosisId = "";
                $("#tab1 .card-body").find("input:eq(2)").each(function(index, element){
                    if($(element).val() != "") {
                        if(diagnosisId != "") {
                            diagnosisId = diagnosisId + "," + $(element).val()
                        } else {
                            diagnosisId = $(element).val();
                        }
                    }
                });
                
                $.ajax
                ({
                    type: "GET",
                    url: $(this).attr('data-url') + "&diagnosisId="+diagnosisId,
                    cache: false,
                    beforeSend: function() {
                        $('#loader').modal('show');
                    },
                    success: function (data) {
                        $('#modal-form-container').html(data);
                        if($(this).attr('data-title')) {
                            $('#modal-form .modal-title').html($(this).attr('data-title'));
                        }
                        $('#modal-form').modal('show');
                    },
                    complete: function() {
                        $('#loader').modal('hide');
                    },
                });
            })

            $(document).on('click', '.show-modal-form-custom2', function(){
                diagnosisId = "";
                $("#tab1 .card-body").find("input:eq(2)").each(function(index, element){
                    if($(element).val() != "") {
                        if(diagnosisId != "") {
                            diagnosisId = diagnosisId + "," + $(element).val()
                        } else {
                            diagnosisId = $(element).val();
                        }
                    }
                });
                
                $.ajax
                ({
                    type: "GET",
                    url: $(this).attr('data-url') + "&reference_type="+$("#action_reference_type").val() + "&reference_id="+$("#action_reference_id").val() + "&reference_name="+$("#action_reference_name").val(),
                    cache: false,
                    beforeSend: function() {
                        $('#loader').modal('show');
                    },
                    success: function (data) {
                        $('#modal-form-container').html(data);
                        if($(this).attr('data-title')) {
                            $('#modal-form .modal-title').html($(this).attr('data-title'));
                        }
                        $('#modal-form').modal('show');
                    },
                    complete: function() {
                        $('#loader').modal('hide');
                    },
                });
            })
        })

        function onGeneratedSickLetter(data) {
            var url = "{{route('sick-letter.index')}}/" + data.data.id;
            $("p.sick-letter").html("<a href='" + url + "'>" + data.data.transaction_no + "</a>");
        }

        function onGeneratedReferenceLetter(data) {
            var url = "{{route('reference-letter.index')}}/" + data.data.id;
            $("p.reference-letter").html("<a href='" + url + "'>" + data.data.transaction_no + "</a>");
        }
    </script>
@endsection

