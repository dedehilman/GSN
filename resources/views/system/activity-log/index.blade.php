@extends('layout', ['title' => Lang::get("Activity Log"), 'subTitle' => Lang::get("Manage data activity-log")])

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
                    <div class="row mb-2">
                        <div class="col-12 d-flex justify-content-between">
                            <div>
                            </div>
                            <div class="btn-group nav view">
                                <a data-toggle="collapse" href="#collapseOne" class="btn btn-default btn-sm" style="padding-top: 8px"><i class="fas fa-filter"></i></a>
                                <a data-toggle="collapse" href="#collapseExport" class="btn btn-default btn-sm" style="padding-top: 8px"><i class="fas fa-download"></i></a>
                                <a data-toggle="tab" href="#tab-table" class="btn btn-default btn-sm active" style="padding-top: 8px"><i class="fas fa-list"></i></a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="collapseOne" class="panel-collapse collapse in" style="padding:10px 0px 0px 0px;">
                                <form id="formSearch">
                                    
                                </form>
                            </div>
                            <div id="collapseExport" class="panel-collapse collapse in" style="padding:10px 0px 0px 0px;">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{__("Export To")}}</label>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-default btn-export" data-type="excel"><i class="fas fa-file-excel mr-2"></i>{{__('Excel')}}</button>
                                        <button type="button" class="btn btn-sm btn-default btn-export" data-type="csv"><i class="fas fa-file-csv mr-2"></i>{{__('CSV')}}</button>
                                        <button type="button" class="btn btn-sm btn-default btn-export" data-type="pdf"><i class="fas fa-file-pdf mr-2"></i>{{__('PDF')}}</button>                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type='checkbox' name="select-all"/></th>
                                <th></th>
                                <th></th>
                                <th>{{ __("Created At") }}</th>
                                <th>{{ __("Log Name") }}</th>
                                <th>{{ __("Description") }}</th>
                                <th>{{ __("Subject Type") }}</th>
                                <th>{{ __("Subject ID") }}</th>
                                <th>{{ __("Causer Type") }}</th>
                                <th>{{ __("Causer ID") }}</th>
                                <th>{{ __("Properties") }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function(){
            $('#datatable').DataTable({
                ajax:
                {
                    url: "{{route('activity-log.datatable')}}",
                    type: 'POST',
                    data: function(data){
                        getDatatableParameter(data);
                    },
                    error: function (xhr, error, thrown) {
                        
                    }
                },
                searching: true,
                columns: [
                    {
                        width: "30px",
                        orderable: false,
                        defaultContent: '',
                        className: 'select-checkbox text-center',
                        render: function(data, type, row)
                        {
                            return "";
                        }
                    },
                    {
                        width: "30px",
                        orderable: false,
                        defaultContent: '',
                        className: 'text-center',
                        visible: false,
                        render: function(data, type, row)
                        {
                            return "<div class='text-danger'><i class='fas fa-trash'></i></div>";
                        }
                    },
                    {
                        width: "30px",
                        orderable: false,
                        defaultContent: '',
                        className: 'text-center',
                        visible: false,
                        render: function(data, type, row)
                        {
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
                        }
                    }, {
                        data: 'created_at',
                        name: 'created_at',
                        defaultContent: ''
                    }, {
                        data: 'log_name',
                        name: 'log_name',
                        defaultContent: ''
                    }, {
                        data: 'description',
                        name: 'description',
                        defaultContent: ''
                    }, {
                        data: 'subject_type',
                        name: 'subject_type',
                        defaultContent: ''
                    }, {
                        data: 'subject_id',
                        name: 'subject_id',
                        defaultContent: ''
                    }, {
                        data: 'causer_type',
                        name: 'causer_type',
                        defaultContent: ''
                    }, {
                        data: 'causer_id',
                        name: 'causer_id',
                        defaultContent: ''
                    }, {
                        data: 'properties',
                        name: 'properties',
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Activity Log")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9,10] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Activity Log")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9,10] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Activity Log")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9,10] }
                    }
                ],
            });
        });
    </script>
@endsection