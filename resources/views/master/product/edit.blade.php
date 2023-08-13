@extends('layout', ['title' => Lang::get("Product"), 'subTitle' => Lang::get("Edit data product")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('product.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label">{{__("Product Type")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="type_name" id="type_name" class="form-control" value="{{$data->productType->name}}" readonly>
                                    <input type="hidden" name="type_id" id="type_id" value="{{$data->type_id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Product List')}}" data-url="{{route('product_type.select')}}" data-handler="onSelectedProductType"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Merk")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="merk" class="form-control required" value="{{$data->merk}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Stock")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="stock" class="form-control required" value="{{$data->stock}}">
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('product.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function onSelectedProductType(data) {
            $('#type_id').val(data[0].id);
            $('#type_name').val(data[0].name);
        }
             
    </script>
@endsection