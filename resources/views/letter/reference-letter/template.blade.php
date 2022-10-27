@if ($data->image)
    <img src="{{ asset($data->image) }}" height="60" style="position: absolute; left: 0px; left: 0px;">
@else
    <img src="{{ asset('public/img/logo_clinic.jpeg') }}" height="60" style="position: absolute; left: 0px; left: 0px;">
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
<table width="100%">
    <tr>
        <td width="20%">No</td>
        <td>: {{$data->transaction_no}}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}</td>
    </tr>
    <tr>
        <td>Kepada Yth</td>
        <td>: @if($data->reference_type == 'Internal') {{$data->referenceClinic->name}} @else {{$data->reference->name}} @endif</td>
    </tr>
    <tr>
        <td>Di</td>
        <td>: @if($data->reference_type == 'Internal') {!!nl2br($data->referenceClinic->address)!!} @else {!!nl2br($data->reference->address)!!} @endif</td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>: Rujukan Pasien</td>
    </tr>
</table>
<p>TS yang terhormat,</p>
<p>Mohon penanganan pasien lebih lanjut:</p>
<table width="100%">
    <tr>
        <td width="5%">I</td>
        <td width="30%">Identitas</td>
        <td>:</td>
    </tr>
    <tr>
        <td></td>
        <td>Nama Pasien</td>
        <td colspan="3">: @if($data->for_relationship == 0) {{$data->patient->name}} @else {{$data->patientRelationship->name}} @endif 
            (@if($data->for_relationship == 0) {{__($data->patient->gender)}} @else {{__($data->patientRelationship->gender)}} @endif)</td>
        <td>Umur</td>
        <td width="30%">: @if($data->for_relationship == 0) {{getAge($data->patient->birth_date)}} @else {{getAge($data->patientRelationship->birth_date)}} @endif Thn</td>
    </tr>
    <tr>
        <td></td>
        <td>Status di Perusahan</td>
        <td colspan="5">: @if($data->for_relationship == 0) Karyawan @else Tanggungan @endif</td>
    </tr>
    <tr>
        <td></td>
        <td>Nama Karyawan</td>
        <td width="30%">: {{$data->patient->name}}</td>
        <td>NPK</td>
        <td width="20%">: {{$data->patient->code}}</td>
        <td>Golongan</td>
        <td width="10%">: {{$data->patient->grade->name ?? ""}}</td>
    </tr>
    <tr>
        <td></td>
        <td>Unit Kerja</td>
        <td width="30%">: {{$data->patient->workUnit->name ?? ""}}</td>
        <td>Status</td>
        <td>: </td>
    </tr>
    <tr>
        <td></td>
        <td>Site</td>
        <td width="30%">: {{$data->patient->afdelink->estate->name ?? ""}}</td>
        <td>TMK</td>
        <td>: {{$data->patient->join_date}}</td>
    </tr>
</table>
<br/>
<table width="100%">
    <tr>
        <td width="5%" rowspan="7" valign="top">II</td>
        <td colspan="2">PHYSIC DIAGNOSTIC</td>
    </tr>
    <tr>
        <td width="5%">1</td>
        <td>Keluhan Utama :</td>
    </tr>
    <tr>
        <td></td>
        <td>Riwayat Penyakit Sekarang :</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Pemeriksaan Fifik :</td>
    </tr>
    <tr>
        <td></td>
        <td>- Vital Sign</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Diagnosa Kerja :</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Terapi Sementara :</td>
    </tr>
</table>
<p>Atas kerjasamanya di ucapkan terimakasih</p>
<table width="100%">
    <tr>
        <td width="70%"></td>
        <td width="30%" align="center">
            {{$data->clinic->location}}, {{\Carbon\Carbon::parse($data->transaction_date)->isoFormat("DD MMMM YYYY")}}<br/>
            Hormat Saya<br/>
            <br/>
            @if ($data->medicalStaff->image)
            <img src="{{ asset($data->medicalStaff->image) }}" height="60">                
            @endif
            <br/>
            <br/>
            {{$data->medicalStaff->name}}
        </td>
    </tr>
</table>