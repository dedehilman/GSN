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
            <th rowspan="2" valign="middle" align="center">NAMA OBAT &amp; ALKES</th>
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
    <tbody>
        @php
            $totalBegin = 0;
            $totalIn = 0;
            $totalTransferIn = 0;
            $totalOut = 0;
            $totalTransferOutClinic = array();
        @endphp
        @foreach ($medicines as $index => $medicine)
            @php
                $totalBegin += ($begin[$medicine->code] ?? 0);
                $totalIn += ($in[$medicine->code] ?? 0);
                $totalTransferIn += ($transferIn[$medicine->code] ?? 0);
                $totalOut += ($out[$medicine->code] ?? 0);
                $totalTransferOut = 0;
            @endphp
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$medicine->code}}</td>
                <td>{{$medicine->name}}</td>
                <td>{{$medicine->unit->name}}</td>
                <td>{{$begin[$medicine->code] ?? 0}}</td>
                <td>{{$transferIn[$medicine->code] ?? 0}}</td>
                <td>{{$in[$medicine->code] ?? 0}}</td>
                <td></td>
                <td>{{$out[$medicine->code] ?? 0}}</td>
                @foreach ($clinics as $value)
                    @foreach ($value as $clinic)
                        @php
                            if(!array_key_exists($clinic->code, $totalTransferOutClinic)) {
                                $totalTransferOutClinic[$clinic->code] = 0;
                            }
                            $totalTransferOutClinic[$clinic->code] += ($transferOutClinic[$medicine->code.$clinic->code] ?? 0);
                            $totalTransferOut += ($transferOutClinic[$medicine->code.$clinic->code] ?? 0);
                        @endphp
                        <td>{{$transferOutClinic[$medicine->code.$clinic->code] ?? 0}}</td>
                    @endforeach
                @endforeach
                <td>{{$totalTransferOut}}</td>
                <td>{{($begin[$medicine->code] ?? 0) + ($in[$medicine->code] ?? 0) + ($transferIn[$medicine->code] ?? 0) - ($out[$medicine->code] ?? 0) - $totalTransferOut}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tr>
        <td colspan="2"><b>STOCK AWAL</b></td>
        <td>{{$totalBegin}}</td>
    </tr>
    <tr>
        <td colspan="2"><b>IN</b></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">ESTATE</td>
        <td>{{$totalTransferIn}}</td>
    </tr>
    <tr>
        <td colspan="2">LOG</td>
        <td>{{$totalIn}}</td>
    </tr>
    <tr>
        <td colspan="2"><b>TOTAL IN</b></td>
        <td>{{$totalTransferIn + $totalIn}}</td>
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
        <td>{{$totalOut}}</td>
    </tr>
    <tr>
        <td colspan="2"><b>JUMLAH OUT {{$reportModel->period->clinic->code}}</b></td>
        <td>{{$totalOut}}</td>
    </tr>
    @foreach ($clinics as $key => $value)
        @php
            $totalTransferOutCompany = 0;
        @endphp
        @foreach ($value as $clinic)
            @php
                $totalTransferOutCompany += ($totalTransferOutClinic[$clinic->code] ?? 0);
            @endphp
            <tr>
                <td colspan="2">{{$clinic->code}}</td>
                <td>{{$totalTransferOutClinic[$clinic->code] ?? 0}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>JUMLAH {{$key}}</b></td>
            <td>{{$totalTransferOutCompany}}</td>
        </tr>
    @endforeach
</table>
<table>
    <tr>
        <td colspan="{{$clinicCount+12}}" align="right">{{$reportModel->period->clinic->location ?? ""}}, {{Carbon\Carbon::now()->isoFormat('DD MMM YYYY')}}</td>
    </tr>
    <tr>
        <td colspan="3" align="center">Diketahui,</td>
        @php
            $col = ($clinicCount+12-14-6)/2;
            $totalCol = ($clinicCount+12-14);
        @endphp
        @for ($i = 0; $i < $col; $i++)
            <td></td>
        @endfor
        <td colspan="8" align="center">Diperiksa,</td>
        @for (; $i < $totalCol-3; $i++)
            <td></td>
        @endfor
        <td colspan="6" align="center">Dibuat,</td>
    </tr>
    <tr>
        <td colspan="3" rowspan="6"></td>
        @for ($i = 0; $i < $col; $i++)
            <td></td>
        @endfor
        <td colspan="8" rowspan="6"></td>
        @for (; $i < $totalCol-3; $i++)
            <td></td>
        @endfor
        <td colspan="6" rowspan="6"></td>
    </tr>
    @for ($i = 0; $i < 5; $i++)
        <tr>
        </tr>
    @endfor
    <tr>
        <td colspan="3" align="center">Medical Section Head</td>
        @for ($i = 0; $i < $col; $i++)
            <td></td>
        @endfor
        <td colspan="8" align="center">Medical Service &amp; Pharmacy Staff</td>
        @for (; $i < $totalCol-3; $i++)
            <td></td>
        @endfor
        <td colspan="6" align="center">Kepala Gudang</td>
    </tr>
</table>