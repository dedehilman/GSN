@extends('layout', ['title' => Lang::get("Diagnosis"), 'subTitle' => Lang::get("Create data diagnosis")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('diagnosis.store')}}" method="POST">
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
                                <input type="text" name="code" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Handling")}}</label>
                            <div class="col-md-9">
                                <textarea name="handling" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Disease")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="disease_name" id="disease_name" class="form-control required" readonly>
                                    <input type="hidden" name="disease_id" id="disease_id">
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
                                        <table class="table table-bordered" id="table-symptom">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __("Symptom") }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('diagnosis.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-symptom-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="symptom_name[]" class="form-control" readonly>
                        <input type="hidden" name="symptoms[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Symptom List')}}" data-url="{{route('symptom.select')}}" data-handler="onSelectedSymptom" data-id="symptom"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $('document').ready(function(){
            $('.btn-add').on('click', function(){
                var clonedRow = $('#table-symptom-tmp tbody tr:last').clone();
                $('#table-symptom tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#symptom_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'symptom_name' + i);
                textInput.eq(2).attr('id', 'symptom_id' + i);
                textInput.val('');
                textInput.eq(0).val(i);
            });

            $(document).on('click', '.show-modal-select', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });
        });

        function removeRow(element)
        {
            $(element).closest('tr').remove();
        }

        function onSelectedSymptom(data) {
            $('#symptom_id'+seqId).val(data[0].id);
            $('#symptom_name'+seqId).val(data[0].code + " - " + data[0].name);
        }

        function onSelected(data) {
            $('#disease_id').val(data[0].id);
            $('#disease_name').val(data[0].name);
        }

    </script>
@endsection