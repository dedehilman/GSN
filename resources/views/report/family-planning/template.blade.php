<table>
    <tr>
        <td colspan="8" align="center">DATA AKSEPTOR KB KLINIK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="8" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
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
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$data->transaction_date}}</td>
                <td>{{$data->patient->name}}</td>
                <td>{{$data->for_relationship == 0 ? $data->patient->name : $data->patientRelationship->name}}</td>
                <td>{{getAge($data->for_relationship == 0 ? $data->patient->birth_date : $data->patientRelationship->birth_date)}}</td>
                <td>{{$data->patient->address}}</td>
                <td>{{$data->patient->code}}</td>
                <td>{{$data->familyPlanningCategory->name ?? ""}}</td>
            </tr>
        @endforeach
    </tbody>
</table>