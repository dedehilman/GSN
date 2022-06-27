@extends('layout', ['title' => Lang::get("Stock Transaction"), 'subTitle' => Lang::get("Edit data stock transaction")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('stock-transaction.update', $data->id)}}" method="POST">
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
                            <label class="col-md-2 col-form-label required">{{__("Transaction No")}}</label>
                            <div class="col-md-4">
                                <input type="text" name="transaction_no" class="form-control required" value="{{$data->transaction_no}}">
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Transaction Type")}}</label>
                            <div class="col-md-4">
                                <select name="transaction_type" class="form-control custom-select required">
                                    <option value=""></option>
                                    <option value="In" @if($data->transaction_type == 'In') selected @endif>{{__("In")}}</option>
                                    <option value="Transfer In" @if($data->transaction_type == 'Transfer In') selected @endif>{{__("Transfer In")}}</option>
                                    <option value="Transfer Out" @if($data->transaction_type == 'Transfer Out') selected @endif>{{__("Transfer Out")}}</option>
                                    <option value="Adjustment" @if($data->transaction_type == 'Adjustment') selected @endif>{{__("Adjustment")}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">{{__("Transaction Date")}}</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                    <input type="text" name="transaction_date" class="form-control required date" value="{{$data->transaction_date}}">
                                </div>
                            </div>
                            <label class="col-md-2 col-form-label required">{{__("Clinic")}}</label>
                            <div class="col-md-4">
                                @include('partials.clinic-picker', [
                                    'clinic' => $data->clinic
                                ])
                                {{-- <div class="input-group">
                                    <input type="text" name="clinic_name" id="clinic_name" class="form-control required" value="{{$data->clinic->code}} {{$data->clinic->name}}">
                                    <input type="hidden" name="clinic_id" id="clinic_id" value="{{$data->clinic->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{__("Reference")}}</label>
                            <div class="col-md-4">
                                <input type="text" name="reference" class="form-control" value="{{$data->reference}}">
                            </div>
                            <label class="col-md-2 col-form-label required new-clinic @if($data->transaction_type != 'Transfer In' && $data->transaction_type != 'Transfer Out') d-none @endif">{{__("New Clinic")}}</label>
                            <div class="col-md-4 new-clinic @if($data->transaction_type != 'Transfer In' && $data->transaction_type != 'Transfer Out') d-none @endif">
                                <div class="input-group">
                                    <input type="text" name="new_clinic_name" id="new_clinic_name" class="form-control required" value="{{$data->newClinic->code ?? ''}} {{$data->newClinic->name ?? ''}}">
                                    <input type="hidden" name="new_clinic_id" id="new_clinic_id" value="{{$data->newClinic->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedNewClinic"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                            <div class="col-md-4">
                                <textarea name="remark" class="form-control" rows="4">{{$data->remark}}</textarea>
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
                                        <table class="table table-bordered" id="table-transaction-detail">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm' id="btn-add-detail" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Medicine') }}</th>
                                                    <th>{{ __('Qty') }}</th>
                                                    <th>{{ __('Remark') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->details ?? [] as $index => $detail)
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: center;">
                                                            <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                                            <input type="hidden" name="transaction_detail_id[]" id="transaction_detail_id{{$index}}" placeholder="" value="{{$detail->id}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="medicine_name[]" id="medicine_name{{$index}}" class="form-control " value="{{$detail->medicine->name}}">
                                                                <input type="hidden" name="medicine_id[]" id="medicine_id{{$index}}" value="{{$detail->medicine->id}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select medicine" id="medicine{{$index}}" data-title="{{__('Medicine List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control " name="qty[]" id="qty{{$index}}" value="{{$detail->qty}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control " name="detail_remark[]" id="detail_remark{{$index}}" value="{{$detail->remark}}">
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
                        <a href="{{route('stock-transaction.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-transaction-detail-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control" readonly style="min-width: 100px" name="transaction_detail_id[]" placeholder="">
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
                    <input type="text" class="form-control " name="qty[]">
                </td>
                <td>
                    <input type="text" class="form-control " name="detail_remark[]">
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function onSelectedNewClinic(data) {
            $('#new_clinic_id').val(data[0].id);
            $('#new_clinic_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicine(data) {
            $('#medicine_id'+seqId).val(data[0].id);
            $('#medicine_name'+seqId).val(data[0].name);
        }
        $(function(){
            $('#btn-add-detail').on('click', function(){
                var clonedRow = $('#table-transaction-detail-tmp tbody tr:last').clone();
                $('#table-transaction-detail tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#transaction_detail_id'+i).length;i++){}

                textInput.eq(0).attr('id', 'transaction_detail_id' + i);
                textInput.eq(1).attr('id', 'medicine_name' + i);
                textInput.eq(2).attr('id', 'medicine_id' + i);
                textInput.val('');

                clonedRow.find('.medicine').attr('id', 'medicine' + i);
            });

            $(document).on('click', '.medicine', function(){
                seqId = $(this).closest('tr').find('input:first').attr('id').replace('transaction_detail_id', '');
            });

            $("select[name='transaction_type']").on('change', function(){
                if($(this).val() == 'Transfer In' || $(this).val() == 'Transfer Out') {
                    $(".new-clinic").removeClass("d-none");
                } else {
                    $(".new-clinic").addClass("d-none");
                }
            })
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }
    </script>
@endsection