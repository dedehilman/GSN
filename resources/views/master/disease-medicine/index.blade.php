@extends('layout', ['title' => Lang::get("Disease Medicine"), 'subTitle' => Lang::get("Manage data disease medicine")])

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
                                @can('disease-medicine-create')                                
                                <a href="{{route('disease-medicine.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
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
                                        <label class="col-md-2 col-form-label">{{__("Disease")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="disease_name" id="disease_name" class="form-control required">
                                                <input type="hidden" name="disease_id" id="disease_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Disease List')}}" data-url="{{route('disease.select')}}" data-handler="onSelectedDisease"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Medicine")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="medicine_name" id="medicine_name" class="form-control required">
                                                <input type="hidden" name="medicine_id" id="medicine_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Medicine List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Medicine Rule")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="medicine_rule_name" id="medicine_rule_name" class="form-control required">
                                                <input type="hidden" name="medicine_rule_id" id="medicine_rule_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Medicine Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedMedicineRule"><i class="fas fa-search"></i></span>
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
                                <th>{{ __("Disease") }}</th>
                                <th>{{ __("Medicine") }}</th>
                                <th>{{ __("Medicine Rule") }}</th>
                                <th>{{ __("Quantity") }}</th>
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
                    url: "{{route('disease-medicine.datatable')}}",
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
                        visible: @can('disease-medicine-delete') true @else false @endcan,
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
                        visible: @can('disease-medicine-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
                        }
                    },
                    {
                        data: 'disease.name',
                        name: 'disease_id',
                        defaultContent: '',
                    },
                    {
                        data: 'medicine.name',
                        name: 'medicine_id',
                        defaultContent: '',
                    },
                    {
                        data: 'medicine_rule.name',
                        name: 'medicine_rule_id',
                        defaultContent: '',
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Disease Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Disease Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Disease Medicine")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    }
                ],
            });
        });

        function onSelectedDisease(data) {
            $('#disease_id').val(data[0].id);
            $('#disease_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicine(data) {
            $('#medicine_id').val(data[0].id);
            $('#medicine_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicine_rule(data) {
            $('#medicine_rule_id').val(data[0].id);
            $('#medicine_rule_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection