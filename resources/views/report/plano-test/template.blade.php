<table>
    <tr>
        <td colspan="5" align="center">HASIL PEMERIKSAAN KEHAMILAN DAN MENYUSUI</td>
    </tr>
    <tr>
        <td colspan="5" align="center">KARYAWATI PENYEMPROT CHEMIST DAN PUPUK {{$reportModel->clinic->name}}</td>
    </tr>
    <tr>
        <td colspan="5" align="center">PERIODE : {{$reportModel->start_date}} - {{$reportModel->end_date}}</td>
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
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td>{{$data->patient->afdelink->name ?? ""}}</td>
                <td>{{$index+1}}</td>
                <td>{{$data->patient->name}}</td>
                <td>{{$data->patient->address}}</td>
                <td>{{__($data->result)}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>