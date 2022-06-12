@extends('layout', ['title' => Lang::get("Disease Medicine"), 'subTitle' => Lang::get("Create data disease medicine")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('disease-medicine.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Disease")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="disease_name" id="disease_name" class="form-control required">
                                    <input type="hidden" name="disease_id" id="disease_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Disease List')}}" data-url="{{route('disease.select')}}" data-handler="onSelectedDisease"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Medicine")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="medicine_name" id="medicine_name" class="form-control required">
                                    <input type="hidden" name="medicine_id" id="medicine_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Medicine List')}}" data-url="{{route('medicine.select')}}" data-handler="onSelectedMedicine"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Medicine Rule")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="medicine_rule_name" id="medicine_rule_name" class="form-control required">
                                    <input type="hidden" name="medicine_rule_id" id="medicine_rule_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Medicine Rule List')}}" data-url="{{route('medicine-rule.select')}}" data-handler="onSelectedMedicineRule"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Quantity")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="qty" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('disease-medicine.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedDisease(data) {
            $('#disease_id').val(data[0].id);
            $('#disease_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicine(data) {
            $('#medicine_id').val(data[0].id);
            $('#medicine_name').val(data[0].code + ' ' + data[0].name);
        }
        function onSelectedMedicineRule(data) {
            $('#medicine_rule_id').val(data[0].id);
            $('#medicine_rule_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection