@extends('layout', ['title' => Lang::get("Clinic"), 'subTitle' => Lang::get("Edit data clinic")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('clinic.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Code")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="code" class="form-control required" value="{{$data->code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                            <div class="col-md-9">
                                <textarea type="text" name="address" class="form-control" rows="3">{{$data->address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control" value="{{$data->phone}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Afdelink") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-striped table-bordered" id="table_clinic_afdelink">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Afdelink List')}}" data-url="{{route('afdelink.select', 'select=multiple')}}" data-handler="onSelectedAfdelink"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Code") }}</th>
                                                    <th>{{ __("Name") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data->afdelinks as $index => $afdelink)
                                                    <tr>
                                                        <td>{{$afdelink->id}}</td>
                                                        <td>{{$afdelink->code}}</td>
                                                        <td>{{$afdelink->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myFormDetail"></div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('clinic.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update-custom"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var table_clinic_afdelink;

        $('document').ready(function(){

            $('#btn-update-custom').on('click', function(){
                getRowData();
                ajaxPut($(this));
            });

            table_clinic_afdelink = $('#table_clinic_afdelink').DataTable({
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
                            return '<span class="btn btn-danger btn-sm" data-id="afdelink" onclick="removeRow(this)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>';
                        }
                    }, {
                        data: 'code',
                        defaultContent: '',
                    }, {
                        data: 'name',
                        defaultContent: '',
                    }
                ],
            });
        });

        function removeRow(element)
        {
            var node = $(element).closest('li').length ? $(element).closest('li') : $(element).closest('tr');
            var type = $(element).data('id');
            if(type == 'afdelink') {
                table_clinic_afdelink.row(node).remove().draw(false);
            }
        }

        function getRowData()
        {
            $("#myFormDetail").empty();
            var data = table_clinic_afdelink.rows().data();
            for(var i=0; i<data.length; i++)
            {
                $('#myFormDetail').append('<input type="hidden" name="afdelinks[]" value="'+data[i].id+'">');
            }
        }

        function onSelectedAfdelink(data) {
            for (var i = 0; i < data.length; i++) {                
                table_clinic_afdelink.row.add({
                    'id': data[i].id,
                    'code': data[i].code,
                    'name': data[i].name,
                }).draw(false);
            }
        }

    </script>
@endsection