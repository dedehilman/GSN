<table>
    <tr>
        <td colspan="17" align="center">REKAPITULASI KUNJUNGAN PASIEN DAN CLINIC COST </td>
    </tr>
    <tr>
        <td colspan="17" align="center">BALAI PENGOBATAN {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="17" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table border="1">
    <thead>
        <tr>
            <th>{{__("Date")}}</th>
            <th>{{__("Number")}}</th>
            <th>{{__("Nama Karyawan")}}</th>
            <th>{{__("Nama Pasien")}}</th>
            <th>{{__("Umur")}}</th>
            <th>{{__("Sex")}}</th>
            <th>{{__("Alamat")}}</th>
            <th>{{__("Unit Kerja")}}</th>
            <th>{{__("NPK")}}</th>
            <th>{{__("Status")}}</th>
            <th>{{__("Diagnosa")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Qty")}}</th>
            <th>{{__("Harga")}}</th>
            <th>{{__("Jumlah")}}</th>
            <th>{{__("Cost")}}</th>
            <th>{{__("Gol Diagnosa")}}</th>
            <th>{{__("Gol Karyawan")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td valign="top">{{$data->transaction_date}}</td>
                <td valign="top">{{$index+1}}</td>
                <td valign="top">{{$data->patient->name}}</td>
                <td valign="top">{{$data->for_relationship == 0 ? $data->patient->name : $data->patientRelationship->name}}</td>
                <td valign="top">{{getAge($data->for_relationship == 0 ? $data->patient->birth_date : $data->patientRelationship->birth_date)}}</td>
                <td valign="top">{{__($data->for_relationship == 0 ? $data->patient->gender : $data->patientRelationship->gender)}}</td>
                <td valign="top">{{$data->patient->address}}</td>
                <td valign="top">{{$data->patient->workUnit->name ?? ""}}</td>
                <td valign="top">{{$data->patient->code}}</td>
                <td valign="top">{{$data->for_relationship == 0 ? "Karyawan" : "Tanggungan"}}</td>
                <td valign="top">
                    @php
                        $diagnones = "";
                        $golDiagnones = "";
                        foreach ($data->diagnoses ?? [] as $diagnosa) {
                            if($diagnones != "") {
                                $diagnones .= "<br/>";
                                $golDiagnones .= "<br/>";
                            }
                            $diagnones .= $diagnosa->diagnosis->name;
                            $golDiagnones .= $diagnosa->diagnosis->disease->diseaseGroup->name;
                        }
                    @endphp
                    {!!$diagnones!!}
                </td>
                <td valign="top">
                    @php
                        $prescription = "";
                        $qty = "";
                        $price = "";
                        $total = "";
                        $cost = 0;
                        foreach ($data->prescriptions ?? [] as $pre) {
                            if($prescription != "") {
                                $prescription .= "<br/>";
                                $qty .= "<br/>";
                                $price .= "<br/>";
                                $total .= "<br/>";
                            }
                            $prescription .= $pre->medicine->name;
                            $qty .= number_format($pre->qty, 2);
                            $price .= number_format($pre->price, 2);
                            $total .= number_format($pre->total, 2);
                            $cost += $pre->total;
                        }
                    @endphp
                    {!!$prescription!!}
                </td>
                <td valign="top" align="right">{!!$qty!!}</td>
                <td valign="top" align="right">{!!$price!!}</td>
                <td valign="top" align="right">{!!$total!!}</td>
                <td valign="top" align="right">{{number_format($cost, 2)}}</td>
                <td valign="top">{!!$golDiagnones!!}</td>
                <td valign="top">{{$data->patient->grade->name ?? ""}}</td>
            </tr>
        @endforeach
    </tbody>
</table>