<table style="border: 1px solid grey" cellpadding="10">
    <tr>
        <td>
            <table>
                <tr>
                    <td align="center" colspan="2">
                        <strong style="font-size: 18px;">{{$clinic->name}}</strong><br/>
                        {{$data->clinic->address}}<br/>
                        Telepon {{$data->clinic->phone}}<br/>
                        <br/>
                    </td>
                </tr>
                <tr>
                    <td width="30%">Nomor</td>
                    <td>: {{$data->transaction_no}}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{$patient->name}}</td>
                </tr>
                <tr>
                    <td>Layanan</td>
                    <td>: {{$service ?? ""}}</td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>: {{$data->medicalStaff->name}}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{Carbon\Carbon::parse($data->created_at)->isoFormat('DD MMMM YYYY HH:mm')}}</td>
                </tr>
                <tr>
                    <td>Jadwal</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="font-size: 80px;font-weight: bold;">
                        {{$queue ?? "1"}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>