@extends('layout', ['title' => Lang::get("Pharmacy"), 'subTitle' => Lang::get("Create data pharmacy")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('pharmacy.store')}}" method="POST">
                @csrf
                <input type="hidden" name="model_id" value="{{request()->get('model_id') ?? ""}}">
                <input type="hidden" name="model_type" value="{{request()->get('model_type') ?? ""}}">

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
                            <label class="col-md-2 col-form-label required">{{__("Transaction No")}}</label>
                            <div class="col-md-4">
                                <input type="text" name="transaction_no" class="form-control required" readonly value="{{__('Auto Generate')}}">
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Clinic")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="clinic_name" id="clinic_name" class="form-control required" readonly value="{{$dataRef->clinic->name ?? ""}}">
                                    <input type="hidden" name="clinic_id" id="clinic_id" value="{{$dataRef->clinic->id ?? ""}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">{{__("Transaction Date")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="transaction_date" class="form-control required date" value="{{\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                            <div class="col-md-4">
                                <textarea name="remark" class="form-control" rows="4"></textarea>
                            </div>
                            <label class="col-md-2 col-form-label required new-clinic d-none">{{__("New Clinic")}}</label>
                            <div class="col-md-4 new-clinic d-none">
                                <div class="input-group">
                                    <input type="text" name="new_clinic_name" id="new_clinic_name" class="form-control required" readonly>
                                    <input type="hidden" name="new_clinic_id" id="new_clinic_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select', 'queryBuilder=0')}}" data-handler="onSelectedNewClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Detail") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-bordered" id="table-pharmacy-detail">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm' id="btn-add-detail" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Product') }}</th>
                                                    <th>{{ __('Rule') }}</th>
                                                    <th>{{ __('Stock') }}</th>
                                                    <th>{{ __('Qty') }}</th>
                                                    <th>{{ __('Actual Qty') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($prescriptions ?? [] as $index => $prescription)
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: center;">
                                                            <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                                            <input type="hidden" class="form-control" readonly style="min-width: 100px" name="pharmacy_detail_id[]" placeholder="" id="pharmacy_detail_id{{$index}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="medicine_name[]" class="form-control " readonly id="medicine_name{{$index}}" value="{{$prescription->medicine->name}}">
                                                                <input type="hidden" name="medicine_id[]" id="medicine_id{{$index}}" value="{{$prescription->medicine->id}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select medicine" data-title="{{__('Product List')}}" data-url="{{route('medicine.select-stock')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="medicine_rule_name[]" class="form-control " readonly id="medicine_rule_name{{$index}}" value="{{$prescription->medicineRule->name}}">
                                                                <input type="hidden" name="medicine_rule_id[]" id="medicine_rule_id{{$index}}" value="{{$prescription->medicineRule->id}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select medicine" data-title="{{__('Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedMedicineRule"><i class="fas fa-search"></i></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control " name="stock_qty[]" readonly value="{{$prescription->stock_qty ?? '0.00'}}" id="stock_qty{{$index}}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control " name="qty[]" readonly value="{{$prescription->qty ?? '0.00'}}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control " name="actual_qty[]" value="{{$prescription->qty ?? '0.00'}}">
                                                        </td>
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
                        <a href="{{route('pharmacy.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-pharmacy-detail-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control" readonly style="min-width: 100px" name="pharmacy_detail_id[]" placeholder="">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="medicine_name[]" class="form-control " readonly>
                        <input type="hidden" name="medicine_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select medicine" data-title="{{__('Product List')}}" data-url="{{route('medicine.select-stock')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="medicine_rule_name[]" class="form-control " readonly>
                        <input type="hidden" name="medicine_rule_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select medicine" data-title="{{__('Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedMedicineRule"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control " name="stock_qty[]" readonly value="0.00">
                </td>
                <td>
                    <input type="number" class="form-control " name="qty[]" readonly value="0.00">
                </td>
                <td>
                    <input type="number" class="form-control " name="actual_qty[]" value="0.00">
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function onSelectedMedicine(data) {
            $('#medicine_id'+seqId).val(data[0].id);
            $('#medicine_name'+seqId).val(data[0].name);
            $('#stock_qty'+seqId).val(data[0].stock);
        }
        function onSelectedMedicineRule(data) {
            $('#medicine_rule_id'+seqId).val(data[0].id);
            $('#medicine_rule_name'+seqId).val(data[0].name);
        }
        function onSelectedClinic(data) {
            $('#clinic_id').val(data[0].id);
            $('#clinic_name').val(data[0].name);
        }
        $(function(){
            $('#btn-add-detail').on('click', function(){
                var clonedRow = $('#table-pharmacy-detail-tmp tbody tr:last').clone();
                $('#table-pharmacy-detail tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#pharmacy_detail_id'+i).length;i++){}

                textInput.eq(0).attr('id', 'pharmacy_detail_id' + i);
                textInput.eq(1).attr('id', 'medicine_name' + i);
                textInput.eq(2).attr('id', 'medicine_id' + i);
                textInput.eq(3).attr('id', 'medicine_rule_name' + i);
                textInput.eq(4).attr('id', 'medicine_rule_id' + i);
                textInput.eq(5).attr('id', 'stock_qty' + i);
                textInput.val('');
                textInput.eq(5).val('0.00');
                textInput.eq(6).val('0.00');
                textInput.eq(7).val('0.00');

                clonedRow.find('.medicine').attr('id', 'medicine' + i);
            });

            $(document).on('click', '.medicine', function(){
                seqId = $(this).closest('tr').find('input:first').attr('id').replace('pharmacy_detail_id', '');
            });
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }

        function setSelectedIds(element) {
            if($(element).attr('data-handler') == 'onSelectedMedicine') {
                dataUrl = $(element).attr('data-url');
                if(dataUrl.indexOf("?") >= 0) {
                    dataUrl = dataUrl.substring(0, dataUrl.indexOf("?"));
                }
                $(element).attr('data-url', dataUrl+"?clinic_id="+$("#clinic_id").val());
            }
        }
    </script>
@endsection