@php
    $prescriptions = \App\Models\Prescription::where('model_type', get_class($data))
            ->where('model_id', $data->id)
            ->get();
@endphp
<table class="table table-bordered table-striped mt-2">
    <thead>
        <tr>
            <th>{{__('Product')}}</th>
            <th>{{__('Rule')}}</th>
            <th>{{__('Stock Qty')}}</th>
            <th>{{__('Qty')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($prescriptions as $prescription)
            <tr>
                <td>{{$prescription->medicine->name}}</td>
                <td>{{$prescription->medicineRule->name}}</td>
                <td>{{$prescription->stock_qty}}</td>
                <td>{{$prescription->qty}}</td>
            </tr>            
        @endforeach
    </tbody>
</table>