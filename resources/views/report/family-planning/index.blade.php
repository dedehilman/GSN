@extends('layout', ['title' => Lang::get("Family Planning"), 'subTitle' => Lang::get("Manage data sick letter report")])

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
                                {{-- @can('family-planning-report-create') --}}
                                <a href="{{route('report.family-planning.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
                                {{-- @endcan --}}
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
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Status")}}</label>
                                        <div class="col-md-4">
                                            <select name="status" class="custom-select">
                                                <option value=""></option>
                                                <option value="0">{{__("Draft")}}</option>
                                                <option value="1">{{__("On Progress")}}</option>
                                                <option value="2">{{__("Completed")}}</option>
                                                <option value="3">{{__("Failed")}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <button type="button" class="btn btn-sm btn-default" id="btn-clear" style="width: 100px;"><i class="fas fa-trash"></i> {{__('Clear')}}</button>
                                            <button type="button" class="btn btn-sm btn-primary" id="btn-search" style="width: 100px;"><i class="fas fa-search"></i> {{__('Search')}}</button>
                                        </div>
                                    </div>
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
                                <th>{{ __("Code") }}</th>
                                <th>{{ __("Runned At") }}</th>
                                <th>{{ __("Finished At") }}</th>
                                <th>{{ __("Num Of Downloaded") }}</th>
                                <th>{{ __("Remark") }}</th>
                                <th>{{ __("Status") }}</th>
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
                    url: "{{route('report.family-planning.datatable')}}",
                    type: 'POST',
                    data: function(data){
                        getDatatableParameter(data);
                    },
                    error: function (xhr, error, thrown) {
                        
                    }
                },
                order: [[4, "desc"]],
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
                        visible: @can('grievance-report-family-planning-delete') true @else false @endcan,
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
                    },
                    {
                        data: 'code',
                        defaultContent: '',
                    },
                    {
                        data: 'runned_at',
                        defaultContent: '',
                    },
                    {
                        data: 'finished_at',
                        defaultContent: '',
                    },
                    {
                        data: 'num_of_downloaded',
                        defaultContent: '',
                    },
                    {
                        data: 'remark',
                        defaultContent: '',
                    },
                    {
                        data: 'status',
                        defaultContent: '',
                        className: 'text-center',
                        render: function(data, type, row)
                        {
                            if(data == '1') {
                                return '<span class="badge badge-warning">{{__("On Progress")}}</span>';
                            } else if(data == '2') {
                                return '<span class="badge badge-success">{{__("Completed")}}</span>';
                            } else if(data == '3') {
                                return '<span class="badge badge-danger">{{__("Failed")}}</span>';
                            }

                            return '<span class="badge badge-primary">{{__("Draft")}}</span>';
                        }
                    }
                ],
                
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Family Planning")}}',
                        exportOptions: { columns: [3, 4, 5, 6, 7, 8] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Family Planning")}}',
                        exportOptions: { columns: [3, 4, 5, 6, 7, 8] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Family Planning")}}',
                        exportOptions: { columns: [3, 4, 5, 6, 7, 8] }
                    }
                ],
            });
        });
    </script>
@endsection