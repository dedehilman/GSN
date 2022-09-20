@php
    $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
    $referenceLetter = \App\Models\ReferenceLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
@endphp
<p class="mt-2">
    @if($sickLetter) <a href="{{route('sick-letter.show', $sickLetter->id ?? '')}}">{{$sickLetter->transaction_no}}</a> @else <a href="#" class="show-modal-form-custom" data-url="{{route('sick-letter.generate', 'model_id='.$data->id."&model_type=".get_class($data))}}">{{__("Generate Sick Letter")}}</a> @endif
</p>
<p>
    @if($referenceLetter) <a href="{{route('reference-letter.show', $referenceLetter->id ?? '')}}">{{$referenceLetter->transaction_no}}</a> @else <a href="#" class="show-modal-form" data-url="{{route('reference-letter.generate', 'model_id='.$data->id."&model_type=".get_class($data))}}">{{__("Generate Reference Letter")}}</a> @endif
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
        })
    </script>
@endsection

