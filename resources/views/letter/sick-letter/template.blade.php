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
<p style="text-align: center; margin-top: 0px;">No: {{$data->transaction_no}}</p>
<p>Yang bertanda tangan dibawah ini, menerangkan bahwa :</p>
<table width="100%">
    <tr>
        <td width="20%">Nama</td>
        <td>: @if($data->for_relationship == 0) {{$data->patient->name}} @else {{$data->patientRelationship->name}} @endif</td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>: @if($data->for_relationship == 0) {{getAge($data->patient->birth_date)}} @else {{getAge($data->patientRelationship->birth_date)}} @endif Tahun</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>: @if($data->for_relationship == 0) {{__($data->patient->gender)}} @else {{__($data->patientRelationship->gender)}} @endif</td>
    </tr>
    <tr>
        <td>Status Karyawan</td>
        <td>: @if($data->for_relationship == 0) Karyawan @else Tanggungan @endif</td>
    </tr>
    <tr>
        <td>Afdelink / Dept</td>
        <td>: {{$data->patient->afdelink->name ?? ''}}</td>
    </tr>
    <tr>
        <td>Diagnosa</td>
        <td>: {{$data->diagnosis->name ?? ''}}</td>
    </tr>
</table>
<p>Dalam keadaan sakit dan memerlukan istirahat selama @if($data->num_of_days == 0) - hari terhitung dari - s/d - @else {{$data->num_of_days}} terhitung dari {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat('dddd, DD MMMM YYYY')}} s/d {{\Carbon\Carbon::parse($data->transaction_date)->addDays($data->num_of_days-1)->isoFormat('dddd, DD MMMM YYYY')}} @endif.</p>
<p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
@if($data->remark)
    <table>
        <tr>
            <td valign="top">Catatan :</td>
            <td>{{$data->remark}}</td>
        </tr>
    </table>
@endif
<table width="100%">
    <tr>
        <td width="70%"></td>
        <td width="30%" align="center">
            {{$data->clinic->location}}, {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}<br/>
            Dibuat Oleh,<br/>
            <br/>
            <img src="{{ asset($data->medicalStaff->image) }}" width="60" height="60">
            <br/>
            <br/>
            {{$data->medicalStaff->name}}
        </td>
    </tr>
</table>