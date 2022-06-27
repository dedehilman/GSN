@extends('layout', ['title' => Lang::get("Reference"), 'subTitle' => Lang::get("Create data reference")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('reference.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Reference Type")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="reference_type_name" id="reference_type_name" class="form-control required">
                                    <input type="hidden" name="reference_type_id" id="reference_type_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Reference Type List')}}" data-url="{{route('reference-type.select')}}" data-handler="onSelectedReferenceType"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('reference.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedReferenceType(data) {
            $('#reference_type_id').val(data[0].id);
            $('#reference_type_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection