<table>
    <tr>
        <td colspan="17" align="center">REKAPITULASI KUNJUNGAN PASIEN DAN CLINIC COST </td>
    </tr>
    <tr>
        <td colspan="17" align="center">BALAI PENGOBATAN {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="17" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table border="1">
    <thead>
        <tr>
            <th>{{__("Date")}}</th>
            <th>{{__("Number")}}</th>
            <th>{{__("Nama Karyawan")}}</th>
            <th>{{__("Nama Pasien")}}</th>
            <th>{{__("Sex")}}</th>
            <th>{{__("Alamat")}}</th>
            <th>{{__("Unit Kerja")}}</th>
            <th>{{__("NPK")}}</th>
            <th>{{__("Status")}}</th>
            <th>{{__("Diagnosa")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Qty")}}</th>
            <th>{{__("Harga")}}</th>
            <th>{{__("Jumlah")}}</th>
            <th>{{__("Cost")}}</th>
            <th>{{__("Gol Diagnosa")}}</th>
            <th>{{__("Gol Karyawan")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->transaction_date}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$index+1}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->name}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->for_relationship == 0 ? $data->patient->name : $data->patientRelationship->name}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{__($data->for_relationship == 0 ? $data->patient->gender : $data->patientRelationship->gender)}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->address}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->workUnit->name ?? ""}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->code}}</td>
                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top"></td>
                @if (count($data->details) > 0)
                    @foreach ($data->details as $index => $detail)
                        @if ($index == 0)
                                <td>{{$detail['diagnosis'] ?? ""}}</td>
                                <td>{{$detail['terapi'] ?? ""}}</td>
                                <td>{{$detail['qty'] ?? ""}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$detail['gol_diagnosis'] ?? ""}}</td>
                                <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->grade->name ?? ""}}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{$detail['diagnosis'] ?? ""}}</td>
                                <td>{{$detail['terapi'] ?? ""}}</td>
                                <td>{{$detail['qty'] ?? ""}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$detail['gol_diagnosis'] ?? ""}}</td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td @if(count($data->details) > 0) rowspan="{{count($data->details)}}" @endif valign="top">{{$data->patient->grade->name ?? ""}}</td>
                </tr>
                @endif
        @endforeach
    </tbody>
</table>