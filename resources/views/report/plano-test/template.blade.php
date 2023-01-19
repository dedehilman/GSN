<table>
    <tr>
        <td colspan="8" align="center">HASIL PEMERIKSAAN KEHAMILAN DAN MENYUSUI</td>
    </tr>
    <tr>
        <td colspan="8" align="center">KARYAWATI PENYEMPROT CHEMIST DAN PUPUK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="8" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>{{__("Afd")}}</th>
            <th>{{__("Number")}}</th>
            <th>{{__("Nama")}}</th>
            <th>{{__("Address")}}</th>
            <th>{{__("Hasil Pemeriksaan")}}</th>
            <th>{{__("Menyusui")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Qty")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td valign="top">{{$data->patient->afdelink->name ?? ""}}</td>
                <td valign="top">{{$index+1}}</td>
                <td valign="top">{{$data->patient->name}}</td>
                <td valign="top">{{$data->patient->address}}</td>
                <td valign="top">{{__($data->result)}}</td>
                <td valign="top"></td>
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