<table>
    <tr>
        <td colspan="17" align="center">DATA KECELAKAAN KERJA</td>
    </tr>
    <tr>
        <td colspan="17" align="center">{{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="17" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th>{{__("Number")}}</th>
            <th>{{__("Tanggal")}}</th>
            <th>{{__("Nama")}}</th>
            <th>{{__("Address")}}</th>
            <th>{{__("Sex")}}</th>
            <th>{{__("NPK")}}</th>
            <th>{{__("Unit Kerja")}}</th>
            <th>{{__("Kategori Kecelekaan")}}</th>
            <th>{{__("Jenis Paparan")}}</th>
            <th>{{__("Luka / Cidera")}}</th>
            <th>{{__("SKS")}}</th>
            <th>{{__("Diagnosa")}}</th>
            <th>{{__("Terapi")}}</th>
            <th>{{__("Qty")}}</th>
            <th>{{__("Harga")}}</th>
            <th>{{__("Jumlah")}}</th>
            <th>{{__("Total Biaya")}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td valign="top">{{$index+1}}</td>
                <td valign="top">{{$data->transaction_date}}</td>
                <td valign="top">{{$data->patient->name}}</td>
                <td valign="top">{{$data->patient->address}}</td>
                <td valign="top">{{__($data->patient->gender)}}</td>
                <td valign="top">{{$data->patient->code}}</td>
                <td valign="top">{{$data->patient->workUnit->name ?? ""}}</td>
                <td valign="top">{{$data->workAccidentCategory->name ?? ""}}</td>
                <td valign="top">{{$data->exposure->name ?? ""}}</td>
                <td valign="top">{{$data->short_description ?? ""}}</td>
                <td valign="top">
                    @php
                        $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                                        ->where('model_id', $data->id)
                                        ->first();
                    @endphp
                    @if ($sickLetter)
                        {{$sickLetter->transaction_no." (".$sickLetter->num_of_days.")"}}
                    @endif
                </td>   
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
                            $prescription .= $pre->medicine->name." ".$pre->medicineRule->name;
                            $qty .= $pre->qty;
                            $price .= number_format($pre->price, 2);
                            $total .= number_format($pre->total, 2);
                            $cost += $pre->total;
                        }
                    @endphp
                    {!!$prescription!!}
                </td>
                <td valign="top">{!!$qty!!}</td>
                <td valign="top" align="right">{!!$price!!}</td>
                <td valign="top" align="right">{!!$total!!}</td>
                <td valign="top" align="right">{{number_format($cost, 2)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>