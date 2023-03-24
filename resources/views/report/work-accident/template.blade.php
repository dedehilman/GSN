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
        @php
            $dataArr = [];
            foreach ($datas as $index => $data) {
                $dataArrTmp = [];
                $dataTmp[0] = $index+1;
                $dataTmp[1] = $data->transaction_date;
                $dataTmp[2] = $data->patient->name;
                $dataTmp[3] = $data->patient->address;
                $dataTmp[4] = $data->patient->gender;
                $dataTmp[5] = $data->patient->code;
                $dataTmp[6] = $data->patient->workUnit->name ?? "";
                $dataTmp[7] = $data->workAccidentCategory->name ?? "";
                $dataTmp[8] = $data->exposure->name ?? "";
                $dataTmp[9] = $data->short_description ?? "";
                $sickLetter = \App\Models\SickLetter::where('model_type', get_class($data))
                                ->where('model_id', $data->id)
                                ->first();
                $dataTmp[10] = $sickLetter ? $sickLetter->transaction_no." (".$sickLetter->num_of_days.")" : "";
                $dataTmp[11] = "";
                $dataTmp[12] = "";
                $dataTmp[13] = "";
                $dataTmp[14] = "";
                $dataTmp[15] = "";
                $dataTmp[16] = "";
                array_push($dataArrTmp, $dataTmp);

                foreach ($data->diagnoses ?? [] as $index => $diagnosa) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 17; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][11] = $diagnosa->diagnosis->name;
                }

                $cost = 0;
                foreach ($data->prescriptions ?? [] as $index => $pre) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 17; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][12] = $pre->medicine->name;
                    $dataArrTmp[$index][13] = $pre->qty;
                    $dataArrTmp[$index][14] = $pre->price;
                    $dataArrTmp[$index][15] = $pre->total;
                    $cost += $pre->total;
                    if($index + 1 == count($data->prescriptions)) {
                        $dataArrTmp[0][16] = $cost;
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
                <td valign="top">{{__($data[4])}}</td>
                <td valign="top">{{$data[5]}}</td>
                <td valign="top">{{$data[6]}}</td>
                <td valign="top">{{$data[7]}}</td>
                <td valign="top">{{$data[8]}}</td>
                <td valign="top">{{$data[9]}}</td>
                <td valign="top">{{$data[10]}}</td>
                <td valign="top">{{$data[11]}}</td>
                <td valign="top">{{$data[12]}}</td>
                <td valign="top" align="right">{{$data[13]}}</td>
                <td valign="top" align="right">{{$data[14]}}</td>
                <td valign="top" align="right">{{$data[15]}}</td>
                <td valign="top" align="right">{{$data[16]}}</td>
            </tr>
        @endforeach
    </tbody>
</table>