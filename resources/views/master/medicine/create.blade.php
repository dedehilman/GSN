@extends('layout', ['title' => Lang::get("Product"), 'subTitle' => Lang::get("Create data product")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('medicine.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Unit")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="unit_name" id="unit_name" class="form-control required" readonly>
                                    <input type="hidden" name="unit_id" id="unit_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Unit List')}}" data-url="{{route('unit.select')}}" data-handler="onSelectedUnit"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Product Type")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="medicine_type_name" id="medicine_type_name" class="form-control required" readonly>
                                    <input type="hidden" name="medicine_type_id" id="medicine_type_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Product Type List')}}" data-url="{{route('medicine-type.select')}}" data-handler="onSelectedProductType"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('medicine.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
    </script>
@endsection