@extends('layout', ['title' => Lang::get("Sick Letter"), 'subTitle' => Lang::get("Manage data sick letter")])

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
                                @can('sick-letter-create')
                                <a href="{{route('sick-letter.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
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
                                                        <input type="text" name="transaction_date.gte" class="form-control date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" name="transaction_date.lte" class="form-control date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
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
                                        <label class="col-md-2 col-form-label">{{__("Medical Staff")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" id="medical_staff_name" class="form-control" readonly>
                                                <input type="hidden" name="medical_staff_id" id="medical_staff_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Medical Staff List')}}" data-url="{{route('medical-staff.select')}}" data-handler="onSelectedMedicalStaff"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Patient")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" id="patient_name" class="form-control" readonly>
                                                <input type="hidden" name="patient_id" id="patient_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Patient List')}}" data-url="{{route('employee.select')}}" data-handler="onSelectedPatient"><i class="fas fa-search"></i></span>
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
                                <th>{{ __("Patient") }}</th>
                                <th>{{ __("Clinic") }}</th>
                                <th>{{ __("Medical Staff") }}</th>
                                <th>{{ __("Transaction No Ref") }}</th>
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
                    url: "{{route('sick-letter.datatable')}}",
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
                        visible: @can('sick-letter-delete') true @else false @endcan,
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
                        visible: @can('sick-letter-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
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
                        name: 'transaction_date',
                        defaultContent: '',
                    },
                    {
                        data: 'patient.name',
                        name: 'patient_id',
                        defaultContent: '',
                    },
                    {
                        data: 'clinic.name',
                        name: 'clinic_id',
                        defaultContent: '',
                    },
                    {
                        data: 'medical_staff.name',
                        name: 'medical_staff_id',
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
                        title: '{{__("Sick Letter")}}',
                        exportOptions: { columns: [3,4,5,6,7,8] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Sick Letter")}}',
                        exportOptions: { columns: [3,4,5,6,7,8] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Sick Letter")}}',
                        exportOptions: { columns: [3,4,5,6,7,8] }
                    }
                ],
            });
        });

        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
        }
        function onSelectedMedicalStaff(data) {
            $('#medical_staff_id').val(data[0].id);
            $('#medical_staff_name').val(data[0].name);
        }
        function onSelectedPatient(data) {
            $('#patient_id').val(data[0].id);
            $('#patient_name').val(data[0].name);
        }
        function onSelectedReferenceTransaction(data) {
            $('#model_type').val(data[0].model_type);
            $('#model_id').val(data[0].id);
            $('#model_transaction_no').val(data[0].transaction_no);
        }
    </script>
@endsection