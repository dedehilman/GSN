@extends('layout', ['title' => Lang::get("Outpatient"), 'subTitle' => Lang::get("Manage data outpatient")])

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
                                        <label class="col-md-2 col-form-label">{{__("Reference Type")}}</label>
                                        <div class="col-md-4">
                                            <select name="reference_type" class="form-control custom-select">
                                                <option value=""></option>
                                                <option value="Internal">{{__("Internal")}}</option>
                                                <option value="External">{{__("External")}}</option>
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Reference")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" id="reference_name" class="form-control" readonly>
                                                <input type="hidden" name="reference_id" id="reference_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select reference-modal-select" data-title="{{__('Reference List')}}" data-url="{{route('reference.select')}}" data-handler="onSelectedReference"><i class="fas fa-search"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Action")}}</label>
                                        <div class="col-md-4">
                                            <div class="form-check pt-2">
                                                <input class="form-check-input" type="checkbox" name="actions.id" value="null" checked>
                                                <label class="form-check-label">{{__("Yes")}}</label>
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
                                <th>{{ __("Reference") }}</th>
                                <th>{{ __("Action") }}</th>
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
                    url: "{{route('action.outpatient.datatable')}}",
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
                        visible: @can('action-outpatient-delete') true @else false @endcan,
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
                        visible: @can('action-outpatient-edit') true @else false @endcan,
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
                        sortable: false,
                        defaultContent: '',
                        render: function(data, type, row)
                        {
                            if(row.reference_type == 'Internal') {
                                return row.reference_type + " - " + row.reference_clinic.name;
                            }

                            return row.reference_type + " - " + row.reference.name;
                        }
                    },
                    {
                        sortable: false,
                        defaultContent: '',
                        render: function(data, type, row)
                        {
                            if(row.action_id == null) {
                                return "Belum Ditindak"
                            }

                            return "Sudah Ditindak";
                        }
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Outpatient")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Outpatient")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Outpatient")}}',
                        exportOptions: { columns: [3,4,5,6,7,8,9] }
                    }
                ],
            });

            $("select[name='reference_type']").on('change', function(){
                $("#reference_id").val("");
                $("#reference_name").val("");
                
                if($(this).val() == 'Internal') {
                    $(".reference-modal-select").attr("data-url", "{{route('clinic.select', 'queryBuilder=0')}}");
                    $("#reference_id").attr("name", "reference_clinic_id");
                } else {
                    $(".reference-modal-select").attr("data-url", "{{route('reference.select')}}");
                    $("#reference_id").attr("name", "reference_id");
                }
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
        function onSelectedReference(data) {
            $('#reference_id').val(data[0].id);
            $('#reference_name').val(data[0].name);
        }
    </script>
@endsection