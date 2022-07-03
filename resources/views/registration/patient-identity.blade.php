@if ($clinic->image)
    <img src="{{ asset($clinic->image) }}" width="60" height="60" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo.png') }}" width="60" height="60" style="position: absolute; left: 0px; left: 0px;">
@endif
<table width="100%">
    <tr>
        <td align="center">
            <strong style="font-size: 24px;">{{$clinic->name}}</strong><br/>
            {{$clinic->address}}<br/>
            Telepon {{$clinic->phone}}
        </td>
    </tr>
</table>
<hr/>
<p style="margin-bottom: 0px; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: center;">IDENTITAS PASIEN</p>
<p style="text-align: center; margin-top: 0px;">No: {{$data->transaction_no}}</p>

<table width="100%">
    <tr>
        <td width="30%">Nama Pasien<br/><i>Patient Name</i></td>
        <td valign="top">: {{$patient->name}}</td>
    </tr>
    <tr>
        <td>Tempat / Tanggal Lahir Pasien<br/><i>Place / Date of Birth</i></td>
        <td valign="top">: {{$patient->birth_place}} / {{$patient->birth_date}}</td>
    </tr>
    <tr>
        <td>Nomor Identitas<br/><i>Identity Number</i></td>
        <td valign="top">: {{$patient->identity_number}}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin<br/><i>Gender</i></td>
        <td valign="top">: {{$patient->gender}}</td>
    </tr>
    <tr>
        <td>Alamat<br/><i>Address</i></td>
        <td valign="top">: {{$patient->address}}</td>
    </tr>
    <tr>
        <td>Email<br/><i>Email</i></td>
        <td valign="top">: {{$patient->email}}</td>
    </tr>
    <tr>
        <td>No. Telepon<br/><i>Phone</i></td>
        <td valign="top">: {{$patient->phone}}</td>
    </tr>
    <tr>
        <td>Layanan<br/><i>Service</i></td>
        <td valign="top">: {{$service ?? ""}}</td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="50%" align="center">
            Pasien, Orang Tua / Keluarga<br/>
            <br/>
            <br/>
            <br/>
            Tata tertib/Hak & kewajiban pasien diserahkan kepada pasien / keluarga
        </td>
        <td align="center">
            Petugas Skrining<br/>
            <br/>
            <br/>
            <br/>
            xxx
        </td>
    </tr>
</table>