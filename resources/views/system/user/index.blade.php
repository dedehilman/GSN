@extends('layout', ['title' => Lang::get("User"), 'subTitle' => Lang::get("Manage data user")])

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
                                @can('user-create')
                                <a href="{{route('user.create')}}" class="btn btn-primary" id="btn-add"><i class="fas fa-plus"></i> {{__('Create')}}</a>                                                
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
                                        <label class="col-md-2 col-form-label">{{__("Username")}}</label>
                                        <div class="col-md-4">
                                            <input type="text" name="username" class="form-control">
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Enabled")}}</label>
                                        <div class="col-md-4 pt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="enabled" value="1" checked>
                                                <label class="form-check-label">{{__("Yes")}}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="enabled" value="0">
                                                <label class="form-check-label">{{__("No")}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">{{__("Name")}}</label>
                                        <div class="col-md-4">
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <label class="col-md-2 col-form-label">{{__("Role")}}</label>
                                        <div class="col-md-4">
                                            <select name="role_id" class="custom-select">
                                                <option value="">{{__('All Role')}}</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
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
                                <th>{{ __("Username") }}</th>
                                <th>{{ __("Name") }}</th>
                                <th>{{ __("Email") }}</th>
                                <th>{{ __("Enabled") }}</th>
                                <th>{{ __("Role") }}</th>
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
                    url: "{{route('user.datatable')}}",
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
                        visible: @can('user-delete') true @else false @endcan,
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
                        visible: @can('user-edit') true @else false @endcan,
                        render: function(data, type, row)
                        {
                            return "<div class='text-primary'><i class='fas fa-edit'></i></div>";
                        }
                    },
                    {
                        data: 'username',
                        name: 'username',
                        defaultContent: '',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        defaultContent: '',
                    },
                    {
                        data: 'email',
                        name: 'email',
                        defaultContent: '',
                    },
                    {
                        data: 'enabled',
                        name: 'enabled',
                        defaultContent: '',
                        width: "100px",
                        className: 'text-center',
                        render: function(data, type, row)
                        {
                            return data == '1' ? '<span class="badge badge-primary">{{ __('Yes') }}</span>' : '<span class="badge badge-danger">{{ __('No') }}</span>';
                        }
                    },
                    {
                        data: 'roles',
                        defaultContent: '',
                        render: function(data, type, row)
                        {
                            var roles = '';
                            for(var i=0;i<data.length;i++) {
                                roles += '<span class="badge badge-primary">'+data[i].name+'</span> ';
                            }
                            
                            return roles;
                        }
                    }
                ],
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{__("User")}}',
                        exportOptions: { columns: [3,4,5,6,7] }
                    },
                    {
                        extend: 'csv',
                        title: '{{__("User")}}',
                        exportOptions: { columns: [3,4,5,6,7] }
                    },
                    {
                        extend: 'pdf',
                        title: '{{__("User")}}',
                        exportOptions: { columns: [3,4,5,6,7] }
                    }
                ],
            });
        });
    </script>
@endsection