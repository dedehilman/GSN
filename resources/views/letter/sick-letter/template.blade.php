@if ($data->image)
    <img src="{{ asset($data->image) }}" width="60" height="60" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo.png') }}" width="60" height="60" style="position: absolute; left: 0px; left: 0px;">
@endif
<table width="100%">
    <tr>
        <td align="center">
            <strong style="font-size: 24px;">{{$data->clinic->name}}</strong><br/>
            {{$data->clinic->address}}<br/>
            Telepon {{$data->clinic->phone}}
        </td>
    </tr>
</table>
<hr/>
<p style="margin-bottom: 0px; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: center;">Surat Keterangan Sakit</p>
<p style="text-align: center; margin-top: 0px;">No: </p>
<p>Yang bertanda tangan dibawah ini Dokter pemeriksa {{$data->medicalStaff->name}}, menerangkan bahwa :</p>
<table width="100%">
    <tr>
        <td width="20%">Nama</td>
        <td>: {{$data->patient->name}}</td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: </td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: {{__($data->patient->gender)}}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: {{$data->patient->address}}</td>
    </tr>
</table>
<p>Perlu beristirahat karena sakit selama {{$data->num_of_days}} hari terhitung dari {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat('dddd, DD MMMM YYYY')}} hingga {{\Carbon\Carbon::parse($data->transaction_date)->addDays($data->num_of_days-1)->isoFormat('dddd, DD MMMM YYYY')}}.</p>
<p>Demikian surat ini dibuat dan diberikan untuk dipergunakan sebagaimana mestinya.</p>
<table width="100%">
    <tr>
        <td width="70%"></td>
        <td width="30%" align="center">
            {{$data->clinic->location}}, {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}<br/>
            <br/>
            <br/>
            <br/>
            <br/>
            {{$data->medicalStaff->name}}
        </td>
    </tr>
</table>