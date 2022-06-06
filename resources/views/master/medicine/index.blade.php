@extends('layout', ['title' => Lang::get("Medicine"), 'subTitle' => Lang::get("Manage data medicine")])

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
                                @can('medicine-create')                                
                                <a href="{{route('medicine.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
                                @endcan
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
                                        <label class="col-md-2 col-form-label">{{__("Code")}}</label>
                                        <div class="col-md-4">
                                            <input type="text" name="code" class="form-control">
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Name")}}</label>
                                        <div class="col-md-4">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Unit")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="unit_name" id="unit_name" class="form-control required">
                                                <input type="hidden" name="unit_id" id="unit_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Unit List')}}" data-url="{{route('unit.select')}}" data-handler="onSelectedUnit"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Medicine Type")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="medicine_type_name" id="medicine_type_name" class="form-control required">
                                                <input type="hidden" name="medicine_type_id" id="medicine_type_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Medicine Type List')}}" data-url="{{route('medicine-type.select')}}" data-handler="onSelectedMedicineType"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
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
                                <th>{{ __("Name") }}</th>
                                <th>{{ __("Unit") }}</th>
                                <th>{{ __("Medicine Type") }}</th>
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
                    url: "{{route('medicine.datatable')}}",
                    type: 'POST',
                    data: function(data){
                        getDatatableParameter(data);
                    },
                    error: function (xhr, error, thrown) {
                        
                    }
                },
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
                        visible: @can('medicine-delete') true @else false @endcan,
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
                        visible: @can('medicine-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
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
                    },
                    {
                        data: 'unit.name',
                        name: 'unit_id',
                        defaultContent: '',
                    },
                    {
                        data: 'medicine_type.name',
                        name: 'medicine_type_id',
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    }
                ],
            });
        });

        function onSelectedUnit(data) {
            $('#unit_id').val(data[0].id);
            $('#unit_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicineType(data) {
            $('#medicine_type_id').val(data[0].id);
            $('#medicine_type_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection