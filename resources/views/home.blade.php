@extends('layout', ["page_title" => Lang::get("Home")])

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="far fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__('Today')}}</span>
                    <span class="info-box-number">
                        {{Carbon\Carbon::now()->isoFormat('DD MMM YYYY')}}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__("Patient")}}</span>
                    <span class="info-box-number">{{$patientCount ?? 0}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-md"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{__("Medical Staff")}}</span>
                    <span class="info-box-number">{{$medicalStaffCount ?? 0}}</span>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-bar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{Carbon\Carbon::now()->isoFormat('YYYY')}}</span>
                    <span class="info-box-number">1200</span>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Top 10 Medicine')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="30px" class="text-center">#</th>
                                <th>{{__("Medicine")}}</th>
                                <th width="50px">{{__("Count")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $topMedicines = \App\Models\Prescription::select("medicines.name", DB::raw("count(*) as total"))
                                                ->join('medicines', 'medicines.id', '=', 'prescriptions.medicine_id')
                                                ->groupBy('medicines.name')
                                                ->orderBy('total', 'DESC')
                                                ->limit(10)
                                                ->get();
                            @endphp
                            @foreach ($topMedicines as $index => $topMedicine)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$topMedicine->name}}</td>
                                    <td class="text-right">{{$topMedicine->total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Top 10 Disease')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Work Accident by Category')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Family Planning by Category')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Plano Test by Result')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Sick Letter by Clinic')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart5"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Reference Letter by Clinic')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart6"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Yearly Chart')}} - {{__('Last 3 years')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('Yearly Chart')}} - {{__('Classification')}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    <script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            var data1 = {
                labels: @json($topDiseases["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($topDiseases["data"]),
                    }
                ]
            };
            var colors2 = [];
            @json($kkBasedOnCategory["data"]).forEach(element => {
                colors2.push(getRandomColor());
            });
            var data2 = {
                labels: @json($kkBasedOnCategory["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : colors2,
                        // borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($kkBasedOnCategory["data"]),
                    }
                ]
            };
            var colors3 = [];
            @json($kbBasedOnCategory["data"]).forEach(element => {
                colors3.push(getRandomColor());
            });
            var data3 = {
                labels: @json($kbBasedOnCategory["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : colors3,
                        // borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($kbBasedOnCategory["data"]),
                    }
                ]
            };
            var data4 = {
                labels: @json($ppTestBasedOnResult["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : ['green','red'],
                        // borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($ppTestBasedOnResult["data"]),
                        
                    }
                ]
            };
            var data5 = {
                labels: @json($slBasedOnClinic["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($slBasedOnClinic["data"]),
                    }
                ]
            };
            var data6 = {
                labels: @json($rlBasedOnClinic["label"]),
                datasets: [
                    {
                        label: "",
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($rlBasedOnClinic["data"]),
                    }
                ]
            };

            var option = {
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            drawOnChartArea:false,
                        },
                    }],
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            drawOnChartArea:false,
                        },
                    }]
                }
            };
            
            new Chart('chart1', {
                type: 'bar',
                options: option,
                data: data1
            });
            new Chart('chart2', {
                type: 'pie',
                data: data2
            });
            new Chart('chart3', {
                type: 'pie',
                data: data3
            });
            new Chart('chart4', {
                type: 'pie',
                data: data4, 
            });
            new Chart('chart5', {
                type: 'bar',
                options: option,
                data: data5,
            });
            var chart6 = new Chart('chart6', {
                type: 'bar',
                options: option,
                data: data6,
            });

            // setTimeout(function(){
            //     var a = document.createElement('a');
            //     a.href = chart6.toBase64Image();
            //     a.download = 'my_file_name.png';
            //     a.click();
            // }, 1000);
        })

        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
    
@endsection