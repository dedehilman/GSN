@extends('layout', ['title' => Lang::get("Stock Taking"), 'subTitle' => Lang::get("Stock taking")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
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
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Period")}}</label>
                        <div class="col-md-9 col-form-label">{{$period->code}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Start Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$period->start_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("End Date")}}</label>
                        <div class="col-md-9 col-form-label">{{$period->end_date}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Clinic")}}</label>
                        <div class="col-md-9 col-form-label">{{$period->clinic->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Export To")}}</label>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-sm btn-default btn-export" data-type="excel"><i class="fas fa-file-excel mr-2"></i>{{__('Excel')}}</button>
                            <button type="button" class="btn btn-sm btn-default btn-export" data-type="csv"><i class="fas fa-file-csv mr-2"></i>{{__('CSV')}}</button>
                            <button type="button" class="btn btn-sm btn-default btn-export" data-type="pdf"><i class="fas fa-file-pdf mr-2"></i>{{__('PDF')}}</button>                                                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-0 pb-4 pr-4 pl-4">
                        <table class="table table-bordered table-striped" id="stock-taking">
                            <thead>
                                <th>{{ __("Product") }}</th>
                                <th>{{ __("Quantity") }}</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $dt)
                                    <tr>
                                        <td>{{$dt->medicine->name}}</td>
                                        <td>{{$dt->qty}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('period.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                    <a href="{{route('period.stock-taking.save', $period->id)}}" class="btn btn-primary"><i class="fas fa fa-save"></i> {{__("Save")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function(){
            $('#stock-taking').DataTable({
                serverSide: false,
                searching: true,
                order: [[0, "asc"]],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Stock Opname")}}',
                        exportOptions: { columns: [0,1] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Stock Opname")}}',
                        exportOptions: { columns: [0,1] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Stock Opname")}}',
                        exportOptions: { columns: [0,1] }
                    }
                ],
            });
        });
    </script>
@endsection