<table>
    <tr>
        <td colspan="13" align="center">DATA AKSEPTOR KB KLINIK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="13" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
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
                $dataTmp[0] = $index+1;
                $dataTmp[1] = $data->transaction_date;
                $dataTmp[2] = $data->patient->name;
                $dataTmp[3] = ($data->for_relationship == 0 || !$data->patientRelationship) ? $data->patient->name : $data->patientRelationship->name;
                $dataTmp[4] = getAge(($data->for_relationship == 0 || !$data->patientRelationship) ? $data->patient->birth_date : $data->patientRelationship->birth_date);
                $dataTmp[5] = $data->patient->address;
                $dataTmp[6] = $data->patient->code;
                $dataTmp[7] = $data->familyPlanningCategory->name ?? "";
                $dataTmp[8] = "";
                $dataTmp[9] = "";
                $dataTmp[10] = "";
                $dataTmp[11] = "";
                $dataTmp[12] = "";
                array_push($dataArrTmp, $dataTmp);

                $cost = 0;
                foreach ($data->prescriptions ?? [] as $index => $pre) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 13; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][8] = $pre->medicine->name;
                    $dataArrTmp[$index][9] = $pre->qty;
                    $dataArrTmp[$index][10] = $pre->price;
                    $dataArrTmp[$index][11] = $pre->total;
                    $cost += $pre->total;
                    if($index + 1 == count($data->prescriptions)) {
                        $dataArrTmp[0][12] = $cost;
                    }
                }

                foreach ($dataArrTmp as $index => $data) {
                    array_push($dataArr, $data);    
                }
            }
        @endphp
        @foreach ($dataArr as $index => $data)
            <tr>
                <td valign="top">{{$data[0]}}</td>
                <td valign="top">{{$data[1]}}</td>
                <td valign="top">{{$data[2]}}</td>
                <td valign="top">{{$data[3]}}</td>
                <td valign="top">{{$data[4]}}</td>
                <td valign="top">{{$data[5]}}</td>
                <td valign="top">{{$data[6]}}</td>
                <td valign="top">{{$data[7]}}</td>
                <td valign="top">{{$data[8]}}</td>
                <td valign="top" align="right">{{$data[9]}}</td>
                <td valign="top" align="right">{{$data[10]}}</td>
                <td valign="top" align="right">{{$data[11]}}</td>
                <td valign="top" align="right">{{$data[12]}}</td>
            </tr>
        @endforeach
    </tbody>
</table>