@extends('layout', ['title' => Lang::get("Department"), 'subTitle' => Lang::get("Manage data department")])

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/jstree/css/default/style.min.css') }}">
@endsection

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
                                <a href="{{route('department.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>
                            </div>
                            <div class="btn-group nav view">
                                <a data-toggle="collapse" href="#collapseOne" class="btn btn-default btn-sm" style="padding-top: 8px"><i class="fas fa-filter"></i></a>
                                <a data-toggle="collapse" href="#collapseExport" class="btn btn-default btn-sm" style="padding-top: 8px"><i class="fas fa-download"></i></a>
                                <a data-toggle="tab" href="#tab-tree" class="btn btn-default btn-sm" style="padding-top: 8px"><i class="fas fa-sitemap"></i></a>
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
                                        <label class="col-2 col-form-label">{{__("Parent")}}</label>
                                        <div class="col-4">
                                            <div class="input-group">
                                                <input type="text" name="parent_name" id="parent_name" class="form-control" readonly>
                                                <input type="hidden" name="parent_id" id="parent_id">
                                                <div class="input-group-append">
                                                    <span class="input-group-text show-modal-select" data-title="{{__('Department List')}}" data-url="{{route('department.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
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
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-table">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type='checkbox' name="select-all"/></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ __("Code") }}</th>
                                        <th>{{ __("Name") }}</th>
                                        <th>{{ __("Parent") }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane pt-3" id="tab-tree">
                            <div id="jstree">
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/jstree/js/jstree.min.js') }}"></script>
    <script>
        $('document').ready(function(){

            $('#jstree').jstree({
                'core': {
                    'check_callback': true,
                    'data' : {
                        'url' : "{{route('department.treeview')}}",
                        "dataType" : "json",
                        'data' : function (node) {
                            return { 'id' : node.id };
                        },
                    },
                },
                "plugins" : [
                    "contextmenu"
                ],
                'contextmenu': {
                    'select_node': false,
                    'items': reportMenu
                }
            }).on('changed.jstree', function (e, data) {
                var i, j, r = [];
                for(i = 0, j = data.selected.length; i < j; i++) {
                    r.push(data.instance.get_node(data.selected[i]).id);
                }
                console.log(r.join(', '));
                orgUnitId = r.join(', ');
                table.ajax.reload(false);
            });

            $('#datatable').DataTable({
                ajax:
                {
                    url: "{{route('department.datatable')}}",
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
                        visible: @can('department-delete') true @else false @endcan,
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
                        visible: @can('department-edit') true @else false @endcan,
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
                        data: 'parent.code',
                        name: 'parent_id',
                        defaultContent: '',
                        render: function(data, type, row)
                        {
                            if(data != null)
                            return data + " " + row.parent.name;
                        }
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("Department")}}',
                        exportOptions: { columns: [3,4,5] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("Department")}}',
                        exportOptions: { columns: [3,4,5] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("Department")}}',
                        exportOptions: { columns: [3,4,5] }
                    }
                ],
            });
        });

        function onSelected(data) {
            $('#parent_id').val(data[0].id);
            $('#parent_name').val(data[0].code + ' ' + data[0].name);
        }

        function reportMenu(node) {
            return {
                // createItem : {
                //     "label" : "New",
                //     "action" : function(obj) { 
                        
                //     },
                //     "_class" : "class"
                // },
                // renameItem : {
                //     "label" : "Edit",
                //     "action" : function(obj) { 
                        
                //     }
                // },
                // deleteItem : {
                //     "label" : "Delete",
                //     "action" : function(obj) { 
                        
                //     }
                // }
            };  
        }
    </script>
@endsection