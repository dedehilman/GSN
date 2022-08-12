@php
    $diagnoses = \App\Models\DiagnosisResult::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<div id="diagnosis-cards" class="pt-2">
    @foreach ($diagnoses as $diagnosis)
        <div class="card" id="diagnosis-card{{$diagnosis->id}}">
            <div class="card-header">
                <h2 class="card-title">{{$diagnosis->diagnosis->code.' - '.$diagnosis->diagnosis->name}}</h2>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{__("Diagnosis")}}</label>
                    <div class="col-md-8 col-form-label">{{$diagnosis->diagnosis->code.' - '.$diagnosis->diagnosis->name}}</div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{__("Symptom")}}</label>
                    <div class="col-md-10">
                        <table class="table table-bordered table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>{{__('Symptom')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diagnosis->symptoms as $symptom)                                
                                    <tr>
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