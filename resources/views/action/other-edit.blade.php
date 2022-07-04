@php
    $sickLetter = \App\Models\SickLetter::where('model_reference_type', get_class($data))
                    ->where('model_reference_id', $data->id)
                    ->first();
    $referenceLetter = \App\Models\ReferenceLetter::where('model_reference_type', get_class($data))
                    ->where('model_reference_id', $data->id)
                    ->first();
@endphp
<p class="mt-2">
    @if($sickLetter) <a href="{{route('sick-letter.show', '1')}}">{{$sickLetter->transaction_no}}</a> @else <a href="#" class="show-modal-form" data-url="{{route('action.plano-test.sick-letter', $data->id)}}">{{__("Generate Sick Letter")}}</a> @endif
</p>
<p>
    @if($referenceLetter) <a href="{{route('reference-letter.show', '1')}}">{{$referenceLetter->transaction_no}}</a> @else <a href="#" class="show-modal-form" data-url="{{route('action.plano-test.reference-letter', $data->id)}}">{{__("Generate Reference Letter")}}</a> @endif
</p>