<table>
    <tr>
        <td colspan="41" align="center">LAPORAN STOK PENERIMAAN / PENGELUARAN OBAT DAN ALKES</td>
    </tr>
    <tr>
        <td colspan="41" align="center">{{$reportModel->period->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="41" align="center">{{$reportModel->period->clinic->estate->company->name ?? ""}}</td>
    </tr>
    <tr>
        <td colspan="41" align="center">PERIODE : {{$reportModel->period->start_date}} - {{$reportModel->period->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th rowspan="2" valign="middle" align="center">NO</th>
            <th rowspan="2" valign="middle" align="center">NAMA OBAT</th>
            <th rowspan="2" valign="middle" align="center">SAT</th>
            <th rowspan="2" valign="middle" align="center">STOCK AWAL</th>
            <th rowspan="2" valign="middle" align="center">IN</th>
            <th colspan="31" valign="middle" align="center">OUT</th>
            <th rowspan="2" valign="middle" align="center">JUMLAH</th>
            <th rowspan="2" valign="middle" align="center">MUTASI</th>
            <th rowspan="2" valign="middle" align="center">ED</th>
            <th rowspan="2" valign="middle" align="center">STOCK AKHIR</th>
            <th rowspan="2" valign="middle" align="center">KET</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 31; $i++)
                <th valign="middle" align="center">{{$i}}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @foreach ($medicines as $index => $medicine)
            @php
                $totalOut = 0;
            @endphp
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$medicine->name}}</td>
                <td>{{$medicine->unit->name}}</td>
                <td>{{$begin[$medicine->code] ?? 0}}</td>
                <td>{{($in[$medicine->code] ?? 0) + ($transferIn[$medicine->code] ?? 0)}}</td>
                @for ($i = 1; $i <= 31; $i++)
                    @php
                        $totalOut += ($outDate[$medicine->code.$i] ?? 0);
                    @endphp
                    <td>{{$outDate[$medicine->code.$i] ?? 0}}</td>
                @endfor
                <td>{{$totalOut}}</td>
                <td>{{$transferOut[$medicine->code] ?? 0}}</td>
                <td></td>
                <td>{{($begin[$medicine->code] ?? 0) + ($in[$medicine->code] ?? 0) + ($transferIn[$medicine->code] ?? 0) - ($transferOut[$medicine->code] ?? 0) - $totalOut}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <tr>
        <td colspan="41" align="right">{{$reportModel->period->clinic->location ?? ""}}, {{Carbon\Carbon::now()->isoFormat('DD MMM YYYY')}}</td>
    </tr>
    <tr>
        <td colspan="2" align="center">Diketahui Oleh,</td>
        @for ($i = 0; $i < 13; $i++)
            <td></td>
        @endfor
        <td colspan="8" align="center">Diperiksa Oleh,</td>
        @for ($i = 0; $i < 12; $i++)
            <td></td>
        @endfor
        <td colspan="6" align="center">Dibuat Oleh,</td>
    </tr>
    <tr>
        <td colspan="2" rowspan="6"></td>
        @for ($i = 0; $i < 13; $i++)
            <td></td>
        @endfor
        <td colspan="8" rowspan="6"></td>
        @for ($i = 0; $i < 12; $i++)
            <td></td>
        @endfor
        <td colspan="6" rowspan="6"></td>
    </tr>
    @for ($i = 0; $i < 5; $i++)
        <tr>
            @for ($j = 0; $j < 25; $j++)
                <td></td>
            @endfor
        </tr>
    @endfor
    <tr>
        <td colspan="2" align="center">Medical Section Head</td>
        @for ($i = 0; $i < 13; $i++)
            <td></td>
        @endfor
        <td colspan="8" align="center">Asst. / Dokter Wilayah</td>
        @for ($i = 0; $i < 12; $i++)
            <td></td>
        @endfor
        <td colspan="6" align="center">Paramedis</td>
    </tr>
</table>