@extends('layout', ['title' => Lang::get("Diagnosis"), 'subTitle' => Lang::get("Edit data diagnosis")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('diagnosis.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label">{{__("Handling")}}</label>
                            <div class="col-md-9">
                                <textarea type="text" name="handling" class="form-control" rows="3">{{$data->handling}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Disease")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="disease_name" id="disease_name" class="form-control required" value="{{$data->disease->name}}">
                                    <input type="hidden" name="disease_id" id="disease_id" value="{{$data->disease->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Disease List')}}" data-url="{{route('disease.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Symptom") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-striped table-bordered" id="table_diagnosis_symptom">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm show-modal-select' style="cursor: pointer" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select', 'select=multiple')}}" data-handler="onSelectedSymptom"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Code") }}</th>
                                                    <th>{{ __("Name") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data->symptoms as $index => $symptom)
                                                    <tr>
                                                        <td>{{$symptom->id}}</td>
                                                        <td>{{$symptom->code}}</td>
                                                        <td>{{$symptom->name}}</td>
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
                        <a href="{{route('diagnosis.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update-custom"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var table_diagnosis_symptom;

        $('document').ready(function(){

            $('#btn-update-custom').on('click', function(){
                getRowData();
                ajaxPut($(this));
            });

            table_diagnosis_symptom = $('#table_diagnosis_symptom').DataTable({
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
                            return '<span class="btn btn-danger btn-sm" data-id="symptom" onclick="removeRow(this)" style="cursor: pointer"><i class="fas fa-trash-alt"></i></span>';
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
            if(type == 'symptom') {
                table_diagnosis_symptom.row(node).remove().draw(false);
            }
        }

        function getRowData()
        {
            $("#myFormDetail").empty();
            var data = table_diagnosis_symptom.rows().data();
            for(var i=0; i<data.length; i++)
            {
                $('#myFormDetail').append('<input type="hidden" name="symptoms[]" value="'+data[i].id+'">');
            }
        }

        function onSelectedSymptom(data) {
            for (var i = 0; i < data.length; i++) {                
                table_diagnosis_symptom.row.add({
                    'id': data[i].id,
                    'code': data[i].code,
                    'name': data[i].name,
                }).draw(false);
            }
        }

        function onSelected(data) {
            $('#disease_id').val(data[0].id);
            $('#disease_name').val(data[0].name);
        }

    </script>
@endsection