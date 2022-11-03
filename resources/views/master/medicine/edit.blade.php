@extends('layout', ['title' => Lang::get("Product"), 'subTitle' => Lang::get("Edit data product")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('medicine.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label">{{__("Unit")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="unit_name" id="unit_name" class="form-control" value="{{$data->unit->name}}" readonly>
                                    <input type="hidden" name="unit_id" id="unit_id" value="{{$data->unit->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Unit List')}}" data-url="{{route('unit.select')}}" data-handler="onSelectedUnit"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Product Type")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="medicine_type_name" id="medicine_type_name" class="form-control" value="{{$data->medicineType->name}}" readonly>
                                    <input type="hidden" name="medicine_type_id" id="medicine_type_id" value="{{$data->medicineType->id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Product Type List')}}" data-url="{{route('medicine-type.select')}}" data-handler="onSelectedProductType"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Price") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-bordered" id="table-medicine-price">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm' id="btn-add-price" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Price') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->prices as $price)
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: center;">
                                                            <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                                            <input type="hidden" class="form-control" readonly style="min-width: 100px" name="medicine_price_id[]" placeholder="" value="{{$price->id}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="effective_date[]" class="form-control required date" value="{{$price->effective_date}}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control required" name="price[]" value="{{$price->price}}">
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
                        <a href="{{route('medicine.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="d-none" id="table-medicine-price-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control" readonly style="min-width: 100px" name="medicine_price_id[]" placeholder="">
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="effective_date[]" class="form-control required date">
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control required" name="price[]">
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function onSelectedUnit(data) {
            $('#unit_id').val(data[0].id);
            $('#unit_name').val(data[0].name);
        }
        function onSelectedProductType(data) {
            $('#medicine_type_id').val(data[0].id);
            $('#medicine_type_name').val(data[0].name);
        }
        $(function(){
            $('#btn-add-price').on('click', function(){
                var clonedRow = $('#table-medicine-price-tmp tbody tr:last').clone();
                $('#table-medicine-price tbody').append(clonedRow);

                $('.date').datepicker({
                    fontAwesome: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    todayBtn: false,
                    clearBtn: true,
                });
            });
        })

        function removeRow(element)
        {
            var tableId = $(element).closest('table').attr("id");
            $(element).closest('tr').remove();
        }
    </script>
@endsection