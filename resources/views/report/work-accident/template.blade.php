<table>
    <tr>
        <td colspan="9" align="center">DATA KECELAKAAN KERJA</td>
    </tr>
    <tr>
        <td colspan="9" align="center">{{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="9" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>{{__("Number")}}</th>
            <th>{{__("Tanggal")}}</th>
            <th>{{__("Nama")}}</th>
            <th>{{__("Address")}}</th>
            <th>{{__("Sex")}}</th>
            <th>{{__("NPK")}}</th>
            <th>{{__("Unit Kerja")}}</th>
            <th>{{__("Jenis Kecelekaan")}}</th>
            <th>{{__("Luka / Cidera")}}</th>
            <th>{{__("SKS")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$data->transaction_date}}</td>
                <td>{{$data->patient->name}}</td>
                <td>{{$data->patient->address}}</td>
                <td>{{__($data->patient->gender)}}</td>
                <td>{{$data->patient->code}}</td>
                <td>{{$data->patient->workUnit->name ?? ""}}</td>
                <td>{{$data->workAccidentCategory->name ?? ""}}</td>
                <td>{{$data->short_description ?? ""}}</td>
                <td>
                    @php
                        $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                                        ->where('model_id', $data->id)
                                        ->first();
                    @endphp
                    @if ($sickLetter)
                        {{$sickLetter->transaction_no." (".$sickLetter->num_of_days.")"}}
                    @endif
                </td>      
            </tr>
        @endforeach
    </tbody>
</table>