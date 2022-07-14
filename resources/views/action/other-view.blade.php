@php
    $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
    $referenceLetter = \App\Models\ReferenceLetter::where('model_type', get_class($data))
                    ->where('model_id', $data->id)
                    ->first();
@endphp
<p class="mt-2">
    @if($sickLetter) <a href="{{route('sick-letter.show', '1')}}">{{$sickLetter->transaction_no}}</a> @endif
</p>
<p>
    @if($referenceLetter) <a href="{{route('reference-letter.show', '1')}}">{{$referenceLetter->transaction_no}}</a> @endif
</p>