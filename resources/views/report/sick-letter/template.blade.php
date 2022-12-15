<table>
    <tr>
        <td colspan="7" align="center">LAPORAN SKS KARYAWAN KLINIK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="7" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table border="1px">
    <thead>
        <tr>
            <th>{{__("Number")}}</th>
            <th>{{__("Tanggal")}}</th>
            <th>{{__("Nama Karyawan")}}</th>
            <th>{{__("Unit Kerja")}}</th>
            <th>{{__("Alamat")}}</th>
            <th>{{__("Diagnosis")}}</th>
            <th>{{__("Jumlah SKS (Hari)")}}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($datas as $index => $data)
            @php
                $total += $data->num_of_days;
            @endphp
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$data->transaction_date}}</td>
                <td>{{$data->patient->name}}</td>
                <td>{{$data->patient->workUnit->name ?? ""}}</td>
                <td>{{$data->patient->address}}</td>
                <td>{{implode(",", $data->diagnoses->pluck('name')->toArray() ?? [])}}</td>
                <td>{{$data->num_of_days}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" align="center">{{__("Total")}}</td>
            <td>{{$total}}</td>
        </tr>
    </tbody>
</table>