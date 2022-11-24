@extends('layout', ['title' => Lang::get("Pharmacy"), 'subTitle' => Lang::get("Manage data pharmacy")])
@section('style')
    <style>
        #datatable-unprocessed tbody td {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Unprocessed") }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="true">{{ __("Processed") }}</a>
                        </li>
                    </ul>
                    {{-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div> --}}
                </div>
                <div class="card-body">  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" style="padding-top: 10px">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <table id="datatable-unprocessed" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type='checkbox' name="select-all"/></th>
                                                <th>{{ __("Transaction No") }}</th>
                                                <th>{{ __("Transaction Date") }}</th>
                                                <th>{{ __("Clinic") }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <div class="row mb-2">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div>
                                                @can('pharmacy-create')                                
                                                <a href="{{route('pharmacy.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
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
                                                        <label class="col-md-2 col-form-label">{{__("Transaction No")}}</label>
                                                        <div class="col-md-4">
                                                            <input type="text" name="transaction_no" class="form-control">
                                                        </div>
                                                        <label class="col-md-2 col-form-label">{{__("Transaction Date")}}</label>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" name="transaction_date.gte" class="form-control date">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" name="transaction_date.lte" class="form-control date">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 col-form-label">{{__("Clinic")}}</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" id="clinic_name" class="form-control" readonly>
                                                                <input type="hidden" name="clinic_id" id="clinic_id">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="col-md-2 col-form-label">{{__("Transaction No Ref")}}</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" id="model_transaction_no" class="form-control" readonly>
                                                                <input type="hidden" name="model_type" id="model_type">
                                                                <input type="hidden" name="model_id" id="model_id">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select" data-title="{{__('Transaction List')}}" data-url="{{route('transaction.select')}}" data-handler="onSelectedReferenceTransaction"><i class="fas fa-search"></i></span>
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
                                                <th>{{ __("Transaction No") }}</th>
                                                <th>{{ __("Transaction Date") }}</th>
                                                <th>{{ __("Clinic") }}</th>
                                                <th>{{ __("Transaction No Ref") }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                  
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
                    url: "{{route('pharmacy.datatable')}}",
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
                        visible: @can('pharmacy-delete') true @else false @endcan,
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
                        visible: @can('pharmacy-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
                            if(row.status == "Publish")
                                return "";
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
                        }
                    },
                    {
                        data: 'transaction_no',
                        name: 'transaction_no',
                        defaultContent: '',
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_no',
                        defaultContent: '',
                    },
                    {
                        data: 'clinic.name',
                        name: 'clinic_id',
                        defaultContent: '',
                    },
                    {
                        data: 'referenceTransaction.transaction_no',
                        sortable: false,
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Pharmacy")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Pharmacy")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Pharmacy")}}',
                        exportOptions: { columns: [3,4,5,6] }
                    }
                ],
            });

            $('#datatable-unprocessed').DataTable({
                order: [[1, "asc"]],
                ajax:
                {
                    url: "{{route('pharmacy.datatable-unprocessed')}}",
                    type: 'POST',
                    data: function(data){
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
                        data: 'transaction_no',
                        name: 'transaction_no',
                        defaultContent: '',
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date',
                        defaultContent: '',
                    },
                    {
                        data: 'clinic_name',
                        name: 'clinic_name',
                        defaultContent: '',
                    }
                ],
            });

            $(document).on('click' , '#datatable-unprocessed tbody td', function() {
                var index = $(this).index();
                var datatable = $('#datatable-unprocessed').DataTable();
                var modelId = datatable.row(this).data().id;
                var modelType = datatable.row(this).data().model_type;
                
                if($(this).closest('td').hasClass('select-checkbox')) {
                    index = 0;
                } else {
                    index = 1;
                }

                if(index == 0) {
                    if(datatable.rows({selected: true}).count() == datatable.rows().count()) {
                        $("#datatable-unprocessed input[type='checkbox'][name='select-all']").prop('checked', true);
                    } else {
                        $("#datatable-unprocessed input[type='checkbox'][name='select-all']").prop('checked', false);
                    }
                }
                else if(index > 0) {
                    datatable.rows().deselect();
                    var url = window.location.toString();
                    window.location.href = url.replace(window.location.search, "").replace("/index", "") + "/create?model_id=" + modelId + "&model_type=" + modelType;
                }
            });
        });

        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
        }
        function onSelectedReferenceTransaction(data) {
            $('#model_type').val(data[0].model_type);
            $('#model_id').val(data[0].id);
            $('#model_transaction_no').val(data[0].transaction_no);
        }
    </script>
@endsection