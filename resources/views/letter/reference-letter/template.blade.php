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
<p style="margin-bottom: 0px; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: center;">Surat Rujukan</p>
<p style="text-align: center; margin-top: 0px;">No: {{$data->transaction_no}}</p>

<p>
    Kepada yang terhormat<br/>
    @if($data->reference_type == 'Internal') {{$data->referenceClinic->name}} @else {{$data->reference->name}} @endif <br/>
    Di<br>
    @if($data->reference_type == 'Internal') {!!nl2br($data->referenceClinic->address)!!} @else {!!nl2br($data->reference->address)!!} @endif
<p>
<p>Kami merujuk pasien</p>
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
        <td>: @if($data->for_relationship == 0) {{__($data->patient->gender)}} @else {{$data->patientRelationship->gender}} @endif</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: @if($data->for_relationship == 0) {{$data->patient->address}} @else {{$data->patientRelationship->address}} @endif</td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td>: {{$data->remark}}</td>
    </tr>
</table>
<p>Mohon perawatan dan penanganan selanjutnya.</p>
<p>Terima Kasih</p>
<table width="100%">
    <tr>
        <td width="70%"></td>
        <td width="30%" align="center">
            {{$data->clinic->location}}, {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}<br/>
            <br/>
            <img src="{{ asset($data->medicalStaff->image) }}" width="60" height="60">
            <br/>
            <br/>
            {{$data->medicalStaff->name}}
        </td>
    </tr>
</table>