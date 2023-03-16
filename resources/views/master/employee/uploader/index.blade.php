@extends('layout', ['title' => Lang::get("Employee Uploader"), 'subTitle' => Lang::get("Data employee uploader")])

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
                                <button type="button" class="btn btn-primary" id="btn-upl-validate" @if($state != 0) disabled @endif>{{__('Validate')}}</button>
                                <button type="button" class="btn btn-primary" id="btn-upl-commit" @if($state != 1) disabled @endif>{{__('Commit')}}</button>
                                <button type="button" class="btn btn-default" id="btn-upl-cancel">{{__('Cancel')}}</button>
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
                                            <select class="custom-select" name="upl_status">
                                                <option value="">{{__('All')}}</option>
                                                <option value="0">{{__('Raw')}}</option>
                                                <option value="1">{{__('Valid')}}</option>
                                                <option value="2">{{__('Invalid')}}</option>
                                                <option value="3">{{__('Failed')}}</option>
                                                <option value="4">{{__('Commited')}}</option>
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
                                <th>{{ __("Number") }}</th>
                                <th>{{ __("Status") }}</th>
                                <th>{{ __("Code") }}</th>
                                <th>{{ __("Name") }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/js/uploader-handler.js') }}"></script>
    <script>
        $('document').ready(function(){
            $('#datatable').DataTable({
                ajax:
                {
                    url: "{{route('employee.uploader.datatable')}}",
                    type: 'POST',
                    data: function(data){
                        getDatatableParameter(data);
                        var urlParams = new URLSearchParams(window.location.search);
                        data.parameters['upl_no'] = urlParams.get("uplNo");
                    },
                    error: function (xhr, error, thrown) {
                        
                    }
                },
                order: [[0, "asc"]],
                columns: [
                    {
                        data: 'upl_line_no',
                        name: 'upl_line_no',
                        defaultContent: '',
                    },
                    {
                        data: 'upl_status',
                        name: 'upl_status',
                        defaultContent: '',
                        render: function(data, type, row)
                        {
                            if(data == 0) {
                                return "{{ __('Raw') }}"
                            } else if(data == 1) {
                                return "{{ __('Valid') }}"
                            } else if(data == 2) {
                                return "{{ __('Invalid') }}"
                            } else if(data == 3) {
                                return "{{ __('Failed') }}"
                            } else if(data == 4) {
                                return "{{ __('Commited') }}"
                            }
                            return "";
                        }
                    },
                    {
                        data: 'code',
                        name: 'code',
                        defaultContent: '',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Employee Uploader")}}',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Employee Uploader")}}',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Employee Uploader")}}',
                        exportOptions: { columns: [0, 1, 2, 3] }
                    }
                ],
            });
        });
    </script>
@endsection