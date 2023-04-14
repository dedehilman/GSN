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
            <th>{{__("Nama Pasien")}}</th>
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
        @php
            $dataArr = [];
            foreach ($datas as $index => $data) {
                $dataArrTmp = [];
                $dataTmp[0] = $data->patientRelation->name ?? $reportModel->patient->name;
                $dataTmp[1] = $data->transaction_date;
                $dataTmp[2] = "";
                $dataTmp[3] = $data->action->remark ?? "";
                $dataTmp[4] = "";
                $dataTmp[5] = "";
                $dataTmp[6] = Lang::get($data->reference_type)." ".($data->reference_type == "Internal" ? $data->reference_clinic : ($data->reference_type == "External" ? $data->reference : ""));
                $dataTmp[7] = $data->service;
                array_push($dataArrTmp, $dataTmp);

                $prevCount = 0;
                foreach ($data->diagnoses ?? [] as $index => $diagnosa) {
                    foreach ($diagnosa->symptoms ?? [] as $index2 => $sy) {
                        if(count($dataArrTmp) <= ($prevCount + $index2)) {
                            $dataTmpBlank = [];
                            for ($i=0; $i < 8; $i++) { 
                                $dataTmpBlank[$i] = "";
                            }
                            array_push($dataArrTmp, $dataTmpBlank);
                        }

                        $dataArrTmp[$prevCount + $index2][2] = $sy->name;
                    }

                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 8; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$prevCount][4] = $diagnosa->diagnosis->name;
                    $prevCount += count($diagnosa->symptoms ?? []);
                }

                foreach ($data->prescriptions ?? [] as $index => $pre) {
                    if(count($dataArrTmp) <= $index) {
                        $dataTmpBlank = [];
                        for ($i=0; $i < 8; $i++) { 
                            $dataTmpBlank[$i] = "";
                        }
                        array_push($dataArrTmp, $dataTmpBlank);
                    }

                    $dataArrTmp[$index][5] = $pre->medicine->name;
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
            </tr>
        @endforeach
    </tbody>
</table>