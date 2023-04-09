<table>
    <tr>
        <td colspan="18" align="center">REKAPITULASI KUNJUNGAN PASIEN DAN CLINIC COST </td>
    </tr>
    <tr>
        <td colspan="18" align="center">BALAI PENGOBATAN {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="18" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
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
        @php
            $dataArr = [];
            foreach ($datas as $index => $data) {
                $dataArrTmp = [];
                $dataTmp[0] = $data->transaction_date;
                $dataTmp[1] = $index+1;
                $dataTmp[2] = $data->patient->name;
                $dataTmp[3] = ($data->for_relationship == 0 || !$data->patientRelationship) ? $data->patient->name : $data->patientRelationship->name;
                $dataTmp[4] = getAge(($data->for_relationship == 0 || !$data->patientRelationship) ? $data->patient->birth_date : $data->patientRelationship->birth_date);
                $dataTmp[5] = ($data->for_relationship == 0 || !$data->patientRelationship) ? $data->patient->gender : $data->patientRelationship->gender;
                $dataTmp[6] = $data->patient->address;
                $dataTmp[7] = $data->patient->workUnit->name ?? "";
                $dataTmp[8] = $data->patient->code;
                $dataTmp[9] = $data->for_relationship == 0 ? "Karyawan" : "Tanggungan";
                $dataTmp[10] = "";
                $dataTmp[11] = "";
                $dataTmp[12] = "";
                $dataTmp[13] = "";
                $dataTmp[14] = "";
                $dataTmp[15] = "";
                $dataTmp[16] = "";
                $dataTmp[17] = $data->patient->grade->name ?? "";
                $dataTmp[18] = 1;
                array_push($dataArrTmp, $dataTmp);

                foreach ($data->diagnoses ?? [] as $index => $diagnosa) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 18; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][10] = $diagnosa->diagnosis->name;
                    $dataArrTmp[$index][16] = $diagnosa->diagnosis->disease->diseaseGroup->name;
                    if($dataArrTmp[0][18] < $index+1) {
                        $dataArrTmp[0][18] = $index+1;
                    }
                }

                $cost = 0;
                foreach ($data->prescriptions ?? [] as $index => $pre) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 18; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][11] = $pre->medicine->name;
                    $dataArrTmp[$index][12] = $pre->qty;
                    $dataArrTmp[$index][13] = $pre->price;
                    $dataArrTmp[$index][14] = $pre->total;
                    $cost += $pre->total;
                    if($index + 1 == count($data->prescriptions)) {
                        $dataArrTmp[0][15] = $cost;
                    }
                    if($dataArrTmp[0][18] < $index+1) {
                        $dataArrTmp[0][18] = $index+1;
                    }
                }

                foreach ($dataArrTmp as $index => $data) {
                    array_push($dataArr, $data);    
                }
            }
        @endphp
        @foreach ($dataArr as $index => $data)
            <tr>
                @if ($data[0] != "")
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[0]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[1]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[2]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[3]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[4]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{__($data[5])}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[6]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[7]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[8]}}</td>
                    <td valign="top" rowspan="{{$data[18]}}">{{$data[9]}}</td>
                @endif
                <td valign="top" rowspan="{{$data[19]}}">{{$data[10]}}{{$data[19]}}</td>
                <td valign="top">{{$data[11]}}</td>
                <td valign="top" align="right">{{$data[12]}}</td>
                <td valign="top" align="right">{{$data[13]}}</td>
                <td valign="top" align="right">{{$data[14]}}</td>
                <td valign="top" align="right">{{$data[15]}}</td>
                <td valign="top">{{$data[16]}}</td>
                <td valign="top">{{$data[17]}}</td>
            </tr>
        @endforeach
    </tbody>
</table>