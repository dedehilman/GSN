<table>
    <tr>
        <td colspan="7" align="center">RIWAYAT PEROBATAN PASIEN</td>
    </tr>
    <tr>
        <td colspan="7" align="center">RAWAT JALAN</td>
    </tr>
</table>
<table>
    <tr>
        <td>Nama</td>
        <td>{{$reportModel->patient->name}}</td>
    </tr>
    <tr>
        <td>Kode</td>
        <td>{{$reportModel->patient->code}}</td>
    </tr>
    <tr>
        <td>SEX</td>
        <td>{{__($reportModel->patient->gender)}}</td>
    </tr>
    <tr>
        <td>UMUR</td>
        <td>{{getAge($reportModel->patient->birth_date)}}</td>
    </tr>
    <tr>
        <td>ALAMAT</td>
        <td>{{$reportModel->patient->address}}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>{{__("Tgl Berobat")}}</th>
            <th>{{__("Keluhan")}}</th>
            <th>{{__("Pemeriksaan")}}</th>
            <th>{{__("Diagnosa")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Keterangan")}}</th>
            <th>{{__("Action")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            <tr>
                <td valign="top">{{$data->transaction_date}}</td>
                <td valign="top">
                    @php
                        $symptom = "";
                        foreach ($data->diagnoses ?? [] as $diagnosa) {
                            foreach ($diagnosa->symptoms ?? [] as $sy) {
                                if($symptom != "") {
                                    $symptom .= "<br/>";
                                }
                                $symptom .= $sy->name;
                            }
                        }
                    @endphp
                    {!!$symptom!!}
                </td>
                <td valign="top">{{$data->action->remark ?? ""}}</td>
                <td valign="top">
                    @php
                        $diagnones = "";
                        foreach ($data->diagnoses ?? [] as $diagnosa) {
                            if($diagnones != "") {
                                $diagnones .= "<br/>";
                            }
                            $diagnones .= $diagnosa->diagnosis->name;
                        }
                    @endphp
                    {!!$diagnones!!}
                </td>
                <td valign="top">
                    @php
                        $prescription = "";
                        foreach ($data->prescriptions ?? [] as $pre) {
                            if($prescription != "") {
                                $prescription .= "<br/>";
                            }
                            $prescription .= $pre->medicine->name;
                        }
                    @endphp
                    {!!$prescription!!}
                </td>
                <td valign="top">{{__($data->reference_type)}} {{$data->reference_type == "Internal" ? $data->reference_clinic : ($data->reference_type == "External" ? $data->reference : "")}}</td>
                <td valign="top">{{$data->service}}</td>
            </tr>
        @endforeach
    </tbody>
</table>