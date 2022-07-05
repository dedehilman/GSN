<table>
    <tr>
        <td colspan="11" align="center">LAPORAN STOK PENERIMAAN / PENGELUARAN OBAT DAN ALKES</td>
    </tr>
    <tr>
        <td colspan="11" align="center">{{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="11" align="center">PERIODE : {{$reportModel->period->start_date}} - {{$reportModel->period->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th rowspan="2" valign="middle">{{__("Code")}}</th>
            <th rowspan="2" valign="middle">{{__("Name")}}</th>
            <th rowspan="2" valign="middle">{{__("Type")}}</th>
            <th rowspan="2" valign="middle">{{__("Unit")}}</th>
            <th rowspan="2" valign="middle">{{__("Begining Stock")}}</th>
            <th rowspan="2" valign="middle">{{__("In")}}</th>
            <th colspan="2">{{__("Transfer")}}</th>
            <th rowspan="2" valign="middle">{{__("Out")}}</th>
            <th rowspan="2" valign="middle">{{__("Adjustment")}}</th>
            <th rowspan="2" valign="middle">{{__("Ending Stok")}}</th>
        </tr>
        <tr>
            <th>{{__("In")}}</th>
            <th>{{__("Out")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medicines as $medicine)
            <tr>
                <td>{{$medicine->code}}</td>
                <td>{{$medicine->name}}</td>
                <td>{{$medicine->medicineType->name}}</td>
                <td>{{$medicine->unit->name}}</td>
                <td>{{$begin[$medicine->code] ?? 0}}</td>
                <td>{{$in[$medicine->code] ?? 0}}</td>
                <td>{{$transferIn[$medicine->code] ?? 0}}</td>
                <td>{{$transferOut[$medicine->code] ?? 0}}</td>
                <td>{{$out[$medicine->code] ?? 0}}</td>
                <td>{{$adj[$medicine->code] ?? 0}}</td>
                <td>{{($begin[$medicine->code] ?? 0) + ($in[$medicine->code] ?? 0) + ($transferIn[$medicine->code] ?? 0) - ($transferOut[$medicine->code] ?? 0) - ($out[$medicine->code] ?? 0) + ($adj[$medicine->code] ?? 0)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>