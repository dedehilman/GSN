@php
    $query1 = \App\Models\PlanoTest::where('patient_id', $data->patient_id)
            ->join('clinics', 'clinics.id', '=', 'plano_tests.clinic_id')
            ->join('medical_staff', 'medical_staff.id', '=', 'plano_tests.medical_staff_id')
            ->select('plano_tests.id', 'transaction_no', 'transaction_date', 'clinics.name AS clinic_name', 'medical_staff.name AS medical_staff_name', DB::Raw('"PP Test" AS service'));
    $query2 = \App\Models\FamilyPlanning::where('patient_id', $data->patient_id)
            ->join('clinics', 'clinics.id', '=', 'family_plannings.clinic_id')
            ->join('medical_staff', 'medical_staff.id', '=', 'family_plannings.medical_staff_id')
            ->select('family_plannings.id', 'transaction_no', 'transaction_date', 'clinics.name AS clinic_name', 'medical_staff.name AS medical_staff_name', DB::Raw('"KB" AS service'));
    $query3 = \App\Models\WorkAccident::where('patient_id', $data->patient_id)
            ->join('clinics', 'clinics.id', '=', 'work_accidents.clinic_id')
            ->join('medical_staff', 'medical_staff.id', '=', 'work_accidents.medical_staff_id')
            ->select('work_accidents.id', 'transaction_no', 'transaction_date', 'clinics.name AS clinic_name', 'medical_staff.name AS medical_staff_name', DB::Raw('"KK" AS service'));
    $query4 = \App\Models\Outpatient::where('patient_id', $data->patient_id)
            ->join('clinics', 'clinics.id', '=', 'outpatients.clinic_id')
            ->join('medical_staff', 'medical_staff.id', '=', 'outpatients.medical_staff_id')
            ->select('outpatients.id', 'transaction_no', 'transaction_date', 'clinics.name AS clinic_name', 'medical_staff.name AS medical_staff_name', DB::Raw('"Rawat Jalan" AS service'));
    if($data->for_relationship == 1) {

    }

    $histories = $query1
                ->unionAll($query2)
                ->unionAll($query3)
                ->unionAll($query4)
                ->orderBy('transaction_date', 'DESC')
                ->get();
@endphp
<table class="table table-bordered table-striped mt-2" id="tableHistory">
    <thead>
        <tr>
            <th>{{__('Transaction No')}}</th>
            <th>{{__('Transaction Date')}}</th>
            <th>{{__('Clinic')}}</th>
            <th>{{__('Medical Staff')}}</th>
            <th>{{__('Service')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($histories as $history)
            <tr>
                @php
                    $url = "";
                    if($history->service == "PP Test") {
                        $url = route("action.plano-test.show", $history->id);
                    } else if($history->service == "KB") {
                        $url = route("action.family-planning.show", $history->id);
                    } else if($history->service == "KK") {
                        $url = route("action.work-accident.show", $history->id);
                    } else if($history->service == "Rawat Jalan") {
                        $url = route("action.outpatient.show", $history->id);
                    }
                @endphp
                <td><a href="{{$url}}" target="_blank">{{$history->transaction_no}}</a></td>
                <td>{{$history->transaction_date}}</td>
                <td>{{$history->clinic_name}}</td>
                <td>{{$history->medical_staff_name}}</td>
                <td>{{$history->service}}</td>
            </tr>
            
        @endforeach
    </tbody>
</table>
@section('scriptHistory')
    <script>
        $(function(){
            $("#tableHistory").DataTable({
                serverSide: false,
                searching: true,
                order: [[1, "desc"]],
                select: false,
            });
        })
    </script>
@endsection