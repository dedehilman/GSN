@extends('layout', ['title' => Lang::get("Role"), 'subTitle' => Lang::get("Create data role")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('role.store')}}" method="POST">
                @csrf
                
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
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Menu") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="true">{{ __("Permission") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="true">{{ __("Record Rule") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-striped table-bordered" id="table_role_menu">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Menu List')}}" data-url="{{route('menu.select', 'select=multiple')}}" data-handler="onSelectedMenu"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Code") }}</th>
                                                    <th>{{ __("Title") }}</th>
                                                    <th>{{ __("Parent") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <table class="table table-striped table-bordered" id="table_role_permission">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Permission List')}}" data-url="{{route('permission.select', 'select=multiple')}}" data-handler="onSelectedPermission"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Name") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <table class="table table-striped table-bordered" id="table_role_record_rule">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Record Rule List')}}" data-url="{{route('record-rule.select', 'select=multiple')}}" data-handler="onSelectedRecordRule"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Name") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myFormDetail"></div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('role.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store-custom"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var table_role_menu, table_role_permission, table_role_record_rule;

        $('document').ready(function(){

            $('#btn-store-custom').on('click', function(){
                getRowData();
                ajaxPost($(this));
            });

            table_role_menu = $('#table_role_menu').DataTable({
                serverSide: false,
                searching: true,
                order: [[1, "asc"]],
                columns: [
                    {
                        data: 'id',
                        defaultContent: '',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            return '<span class="btn btn-danger btn-sm" data-id="menu" onclick="removeRow(this)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>';
                        }
                    }, {
                        data: 'code',
                        defaultContent: '',
                    }, {
                        data: 'title',
                        defaultContent: '',
                    }, {
                        data: 'parent_id',
                        defaultContent: '',
                    }
                ],
            });

            table_role_permission = $('#table_role_permission').DataTable({
                serverSide: false,
                searching: true,
                order: [[1, "asc"]],
                columns: [
                    {
                        data: 'id',
                        defaultContent: '',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            return '<span class="btn btn-danger btn-sm" data-id="permission" onclick="removeRow(this)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>';
                        }
                    }, {
                        data: 'name',
                        defaultContent: '',
                    }
                ]
            });

            table_role_record_rule = $('#table_role_record_rule').DataTable({
                serverSide: false,
                searching: true,
                order: [[1, "asc"]],
                columns: [
                    {
                        data: 'id',
                        defaultContent: '',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            return '<span class="btn btn-danger btn-sm" data-id="record-rule" onclick="removeRow(this)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>';
                        }
                    }, {
                        data: 'name',
                        defaultContent: '',
                    }
                ]
            });
        });

        function removeRow(element)
        {
            var node = $(element).closest('li').length ? $(element).closest('li') : $(element).closest('tr');
            var type = $(element).data('id');
            if(type == 'menu') {
                table_role_menu.row(node).remove().draw(false);
            } else if(type == 'permission') {
                table_role_permission.row(node).remove().draw(false);
            } else if(type == 'record-rule') {
                table_role_record_rule.row(node).remove().draw(false);
            }
        }

        function getRowData()
        {
            $("#myFormDetail").empty();
            var data = table_role_menu.rows().data();
            for(var i=0; i<data.length; i++)
            {
                $('#myFormDetail').append('<input type="hidden" name="menus[]" value="'+data[i].id+'">');
            }

            data = table_role_permission.rows().data();
            for(var i=0; i<data.length; i++)
            {
                $('#myFormDetail').append('<input type="hidden" name="permissions[]" value="'+data[i].id+'">');
            }

            data = table_role_record_rule.rows().data();
            for(var i=0; i<data.length; i++)
            {
                $('#myFormDetail').append('<input type="hidden" name="record_rules[]" value="'+data[i].id+'">');
            }
        }

        function onSelectedMenu(data) {
            for (var i = 0; i < data.length; i++) {                
                table_role_menu.row.add({
                    'id': data[i].id,
                    'code': data[i].code,
                    'title': data[i].title,
                    'parent_id': data[i].parent_id,
                }).draw(false);
            }
        }

        function onSelectedPermission(data) {
            for (var i = 0; i < data.length; i++) {                
                table_role_permission.row.add({
                    'id': data[i].id,
                    'name': data[i].name,
                }).draw(false);
            }
        }

        function onSelectedRecordRule(data) {
            for (var i = 0; i < data.length; i++) {                
                table_role_record_rule.row.add({
                    'id': data[i].id,
                    'name': data[i].name,
                }).draw(false);
            }
        }

    </script>
@endsection