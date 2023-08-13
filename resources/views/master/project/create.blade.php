@extends('layout', ['title' => Lang::get("Project"), 'subTitle' => Lang::get("Create data product project")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('project.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("User Name")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="name" id="name" class="form-control required" readonly>
                                    <input type="hidden" name="user_id" id="user_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('User List')}}" data-url="{{route('user.select')}}" data-handler="onSelectedUser"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Client Name")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="client_name" id="client_name" class="form-control required" readonly>
                                    <input type="hidden" name="client_id" id="client_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Client List')}}" data-url="{{route('client.select')}}" data-handler="onSelectedClient"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Project Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="project_name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Product Name")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="product_name" id="product_name" class="form-control required" readonly>
                                    <input type="hidden" name="product_id" id="product_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Product List')}}" data-url="{{route('product.select')}}" data-handler="onSelectedProduct"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Serial Numbers")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="serial_numbers" class="form-control required">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Serial Numbers")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="serial_numbers[]" id="serial_numbers" class="form-control required" readonly>
                                    <input type="hidden" name="serial_number_id[]" id="serial_number_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Serial Number List')}}" data-url="{{route('serial_number.select', ['select' => 'multiple'])}}" data-handler="onSelectedSerialNumber"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Location")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="location" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Status")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="status" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('project.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function onSelectedProduct(data) {
            $('#product_id').val(data[0].id);
            $('#product_name').val(data[0].name);
        }
        function onSelectedUser(data) {
            $('#user_id').val(data[0].id);
            $('#name').val(data[0].name);
        }
        function onSelectedClient(data) {
            $('#client_id').val(data[0].id);
            $('#client_name').val(data[0].name);
        }
        function onSelectedSerialNumber(data) {
            $('#serial_numbers').val(data[0].number);
            $('#serial_number_id').val(data[0].id);
        }  
    </script>
@endsection