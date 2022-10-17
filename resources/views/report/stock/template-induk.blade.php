<table>
    <tr>
        <td colspan="{{$clinicCount+12}}" align="center">LAPORAN STOK PENERIMAAN / PENGELUARAN OBAT DAN ALKES</td>
    </tr>
    <tr>
        <td colspan="{{$clinicCount+12}}" align="center">{{$reportModel->period->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="{{$clinicCount+12}}" align="center">{{$reportModel->period->clinic->estate->company->name ?? ""}}</td>
    </tr>
    <tr>
        <td colspan="{{$clinicCount+12}}" align="center">PERIODE : {{$reportModel->period->start_date}} - {{$reportModel->period->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th colspan="3" valign="middle" align="center">PT</th>
            <th rowspan="3" valign="middle" align="center">SAT</th>
            <th rowspan="3" valign="middle" align="center">STOCK AWAL</th>
            <th colspan="2" valign="middle" align="center">IN</th>
            <th colspan="2" valign="middle" align="center">{{$reportModel->period->clinic->code}}</th>
            @foreach ($clinics as $key => $value)
                <th @if(count($value) > 1) colspan="{{count($value)}}" @endif valign="middle" align="center">{{$key}}</th>
            @endforeach
            <th rowspan="3" valign="middle" align="center">TOTAL OUT</th>
            <th rowspan="3" valign="middle" align="center">STOCK AKHIR</th>
            <th rowspan="3" valign="middle" align="center">HARGA</th>
        </tr>
        <tr>
            <th rowspan="2" valign="middle" align="center">NO</th>
            <th rowspan="2" valign="middle" align="center">KODE</th>
            <th rowspan="2" valign="middle" align="center">NAMA OBAT ALKES</th>
            <th rowspan="2" valign="middle" align="center">ESTATE</th>
            <th rowspan="2" valign="middle" align="center">LOG</th>
            <th @if(($clinicCount + 2) > 1) colspan="{{$clinicCount+2}}" @endif valign="middle" align="center">OUT</th>
        </tr>
        <tr>
            <th valign="middle" align="center">ED</th>
            <th valign="middle" align="center">APT</th>
            @foreach ($clinics as $value)
                @foreach ($value as $clinic)
                    <th valign="middle" align="center">{{$clinic->code}}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
</table>

<table>
    <tr>
        <td colspan="2"><b>STOCK AWAL</b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><b>IN</b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">ESTATE</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">LOG</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><b>TOTAL IN</b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><b>OUT</b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">ED</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">APOTIK</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><b>JUMLAH OUT {{$reportModel->period->clinic->code}}</b></td>
        <td></td>
    </tr>
    @foreach ($clinics as $key => $value)
        @foreach ($value as $clinic)
            <tr>
                <td colspan="2">{{$clinic->code}}</td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>JUMLAH {{$key}}</b></td>
            <td></td>
        </tr>
    @endforeach
</table>