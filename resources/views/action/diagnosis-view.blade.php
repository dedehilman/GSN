@php
    $diagnoses = \App\Models\DiagnosisResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
    $symptoms = \App\Models\SymptomResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<table class="table table-bordered table-striped mt-2">
    <thead>
        <tr>
            <th>{{__('Symptom')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($symptoms as $symptom)
            <tr>
                <td>{{$symptom->symptom->code.' - '.$symptom->symptom->name}}</td>
            </tr>            
        @endforeach
    </tbody>
</table>
<table class="table table-bordered table-striped mt-2">
    <thead>
        <tr>
            <th>{{__('Diagnosis')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($diagnoses as $diagnosis)
            <tr>
                <td>{{$diagnosis->diagnosis->code.' - '.$diagnosis->diagnosis->name}}</td>
            </tr>            
        @endforeach
    </tbody>
</table>