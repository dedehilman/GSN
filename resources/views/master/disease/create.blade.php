@extends('layout', ['title' => Lang::get("Disease"), 'subTitle' => Lang::get("Create data disease")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('disease.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Disease Group")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="disease_group_name" id="disease_group_name" class="form-control required">
                                    <input type="hidden" name="disease_group_id" id="disease_group_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Disease Group List')}}" data-url="{{route('disease-group.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Medicine") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-bordered" id="table-disease-medicine">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm' id="btn-add-medicine" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Medicine') }}</th>
                                                    <th>{{ __('Rule') }}</th>
                                                    <th>{{ __('Qty') }}</th>
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
                        <a href="{{route('disease.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-disease-medicine-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control" readonly style="min-width: 100px" name="disease_medicine_id[]" placeholder="">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="medicine_name[]" class="form-control ">
                        <input type="hidden" name="medicine_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select medicine" data-title="{{__('Medicine List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="medicine_rule_name[]" class="form-control ">
                        <input type="hidden" name="medicine_rule_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select medicine-rule" data-title="{{__('Medicine Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedMedicineRule"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control " name="qty[]">
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function onSelected(data) {
            $('#disease_group_id').val(data[0].id);
            $('#disease_group_name').val(data[0].name);
        }

        function onSelectedMedicine(data) {
            $('#medicine_id'+seqId).val(data[0].id);
            $('#medicine_name'+seqId).val(data[0].name);
        }

        function onSelectedMedicineRule(data) {
            $('#medicine_rule_id'+seqId).val(data[0].id);
            $('#medicine_rule_name'+seqId).val(data[0].name);
        }

        $(function(){
            $('#btn-add-medicine').on('click', function(){
                var clonedRow = $('#table-disease-medicine-tmp tbody tr:last').clone();
                $('#table-disease-medicine tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#disease_medicine_id'+i).length;i++){}

                textInput.eq(0).attr('id', 'disease_medicine_id' + i);
                textInput.eq(1).attr('id', 'medicine_name' + i);
                textInput.eq(2).attr('id', 'medicine_id' + i);
                textInput.eq(3).attr('id', 'medicine_rule_name' + i);
                textInput.eq(4).attr('id', 'medicine_rule_id' + i);
                textInput.val('');

                clonedRow.find('.medicine').attr('id', 'medicine' + i);
            });

            $(document).on('click', '.medicine', function(){
                seqId = $(this).closest('tr').find('input:first').attr('id').replace('disease_medicine_id', '');
            });
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }
    </script>
@endsection