<table>
    <tr>
        <td colspan="10" align="center">DATA AKSEPTOR KB KLINIK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="10" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>{{__("Number")}}</th>
            <th>{{__("Tanggal")}}</th>
            <th>{{__("Nama Karyawan")}}</th>
            <th>{{__("Nama Pasien")}}</th>
            <th>{{__("Umur")}}</th>
            <th>{{__("Alamat")}}</th>
            <th>{{__("NPK")}}</th>
            <th>{{__("Kontrasepsi")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Qty")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td valign="top">{{$index+1}}</td>
                <td valign="top">{{$data->transaction_date}}</td>
                <td valign="top">{{$data->patient->name}}</td>
                <td valign="top">{{$data->for_relationship == 0 ? $data->patient->name : $data->patientRelationship->name}}</td>
                <td valign="top">{{getAge($data->for_relationship == 0 ? $data->patient->birth_date : $data->patientRelationship->birth_date)}}</td>
                <td valign="top">{{$data->patient->address}}</td>
                <td valign="top">{{$data->patient->code}}</td>
                <td valign="top">{{$data->familyPlanningCategory->name ?? ""}}</td>
                <td valign="top">
                    @php
                        $prescription = "";
                        $qty = "";
                        foreach ($data->prescriptions ?? [] as $pre) {
                            if($prescription != "") {
                                $prescription .= "<br/>";
                                $qty .= "<br/>";
                            }
                            $prescription .= $pre->medicine->name." ".$pre->medicineRule->name;
                            $qty .= $pre->qty;
                        }
                    @endphp
                    {!!$prescription!!}
                </td>
                <td valign="top">{!!$qty!!}</td>
            </tr>
        @endforeach
    </tbody>
</table>