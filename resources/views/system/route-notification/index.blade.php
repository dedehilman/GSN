@extends('layout', ['title' => Lang::get("Route Notification"), 'subTitle' => Lang::get("Manage data route notification")])

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
                                @can('route-notification-create')
                                <a href="{{route('route.notification.create', ['parentId'=>$data->id])}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>                                                
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
                                        <label class="col-md-2 col-form-label">{{__("Trigger")}}</label>
                                        <div class="col-md-4">
                                            <select name="workflow_trigger" class="custom-select">
                                                <option value="">{{__("All Trigger")}}</option>
                                                @foreach (getWorkflowTrigger() as $trigger)
                                                    <option value="{{$trigger}}">{{$trigger}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Recipient")}}</label>
                                        <div class="col-md-4">
                                            <select name="workflow_recipient" class="custom-select">
                                                <option value="">{{__("All Recipient")}}</option>
                                                @foreach (getWorkflowRecipient() as $recipient)
                                                    <option value="{{$recipient}}">{{$recipient}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Notification Template")}}</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" name="notification_template_name" id="notification_template_name" class="form-control required">
                                                <input type="hidden" name="notification_template_id" id="notification_template_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Notificaton Template List')}}" data-url="{{route('notification-template.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
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
                                <th>{{ __("Trigger") }}</th>
                                <th>{{ __("Recipient") }}</th>
                                <th>{{ __("Notification Template") }}</th>
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
                    url: "{{route('route.notification.datatable', ['parentId'=>$data->id])}}",
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
                        visible: @can('route-notification-delete') true @else false @endcan,
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
                        visible: @can('route-notification-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
                        }
                    },
                    {
                        data: 'workflow_trigger',
                        name: 'workflow_trigger',
                        defaultContent: '',
                    },
                    {
                        data: 'workflow_recipient',
                        name: 'workflow_recipient',
                        defaultContent: '',
                    },
                    {
                        data: 'notification_template.name',
                        name: 'notification_template_id',
                        defaultContent: '',
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Route Notification")}}',
                        exportOptions: { columns: [3,4,5] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Route Notification")}}',
                        exportOptions: { columns: [3,4,5] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Route Notification")}}',
                        exportOptions: { columns: [3,4,5] }
                    }
                ],
            });
        });

        function onSelected(data) {
            $('#notification_template_id').val(data[0].id);
            $('#notification_template_name').val(data[0].name);
        }
    </script>
@endsection