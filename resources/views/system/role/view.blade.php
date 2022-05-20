@extends('layout', ['title' => Lang::get("Role"), 'subTitle' => Lang::get("View data role")])

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
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
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
                                                <th>{{ __("Code") }}</th>
                                                <th>{{ __("Title") }}</th>
                                                <th>{{ __("Parent") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->menus as $index => $menu)
                                                <tr>
                                                    <td>{{$menu->code}}</td>
                                                    <td>{{$menu->title}}</td>
                                                    <td>{{$menu->parent_id}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <table class="table table-striped table-bordered" id="table_role_permission">
                                        <thead>
                                            <tr>
                                                <th>{{ __("Name") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->permissions as $index => $permission)
                                                <tr>
                                                    <td>{{$permission->name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel">
                                    <table class="table table-striped table-bordered" id="table_role_record_rule">
                                        <thead>
                                            <tr>
                                                <th>{{ __("Name") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->recordRules as $index => $recordRule)
                                                <tr>
                                                    <td>{{$recordRule->name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('role.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    $.extend(true, $.fn.dataTable.defaults, {
        serverSide: false,
        searching: true,
        order: [[0, "asc"]],
    });
    
    $('document').ready(function(){

        $('#table_role_menu').DataTable({ 
        });

        $('#table_role_permission').DataTable({
        });

        $('#table_role_record_rule').DataTable({
        });
    });

    </script>
@endsection