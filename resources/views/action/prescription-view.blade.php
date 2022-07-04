@php
    $prescriptions = \App\Models\Prescription::where('model_reference_type', get_class($data))
            ->where('model_reference_id', $data->id)
            ->get();
@endphp
<table class="table table-bordered table-striped mt-2">
    <thead>
        <tr>
            <td>{{__('Product')}}</td>
            <td>{{__('Qty')}}</td>
            <td>{{__('Rule')}}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($prescriptions as $prescription)
            <tr>
                <td>{{$prescription->medicine->name}}</td>
                <td>{{$prescription->qty}}</td>
                <td>{{$prescription->medicineRule->name}}</td>
            </tr>            
        @endforeach
    </tbody>
</table>