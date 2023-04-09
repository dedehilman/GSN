<table>
    <tr>
        <td colspan="11" align="center">HASIL PEMERIKSAAN KEHAMILAN DAN MENYUSUI</td>
    </tr>
    <tr>
        <td colspan="11" align="center">KARYAWATI PENYEMPROT CHEMIST DAN PUPUK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="11" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
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
            <th>{{__("Harga")}}</th>
            <th>{{__("Jumlah")}}</th>
            <th>{{__("Total Biaya")}}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $dataArr = [];
            foreach ($datas as $index => $data) {
                $dataArrTmp = [];
                $dataTmp[0] = $data->patient->afdelink->name ?? "";
                $dataTmp[1] = $index+1;
                $dataTmp[2] = $data->patient->name;
                $dataTmp[3] = $data->patient->address;
                $dataTmp[4] = $data->result;
                $dataTmp[5] = "";
                $dataTmp[6] = "";
                $dataTmp[7] = "";
                $dataTmp[8] = "";
                $dataTmp[9] = "";
                $dataTmp[10] = "";
                $dataTmp[11] = 1;
                array_push($dataArrTmp, $dataTmp);

                $cost = 0;
                foreach ($data->prescriptions ?? [] as $index => $pre) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 11; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][6] = $pre->medicine->name;
                    $dataArrTmp[$index][7] = $pre->qty;
                    $dataArrTmp[$index][8] = $pre->price;
                    $dataArrTmp[$index][9] = $pre->total;
                    $cost += $pre->total;
                    if($index + 1 == count($data->prescriptions)) {
                        $dataArrTmp[0][10] = $cost;
                    }
                    $dataArrTmp[0][11] = $index+1;
                }

                foreach ($dataArrTmp as $index => $data) {
                    array_push($dataArr, $data);    
                }
            }
        @endphp
        @foreach ($dataArr as $index => $data)
            <tr>
                @if ($data[0] != "")
                    <td valign="top" rowspan="{{$data[11]}}">{{$data[0]}}</td>
                    <td valign="top" rowspan="{{$data[11]}}">{{$data[1]}}</td>
                    <td valign="top" rowspan="{{$data[11]}}">{{$data[2]}}</td>
                    <td valign="top" rowspan="{{$data[11]}}">{{$data[3]}}</td>
                    <td valign="top" rowspan="{{$data[11]}}">{{__($data[4])}}</td>
                    <td valign="top" rowspan="{{$data[11]}}">{{$data[5]}}</td>
                @endif
                <td valign="top">{{$data[6]}}</td>
                <td valign="top" align="right">{{$data[7]}}</td>
                <td valign="top" align="right">{{$data[8]}}</td>
                <td valign="top" align="right">{{$data[9]}}</td>
                <td valign="top" align="right">{{$data[10]}}</td>
            </tr>
        @endforeach
    </tbody>
</table>