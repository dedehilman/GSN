@extends('layout', ['title' => Lang::get("Clinic"), 'subTitle' => Lang::get("Create data clinic")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('clinic.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label">{{__("Logo")}}</label>
                            <div class="col-md-9">
                                <img src="{{ asset('public/img/200.png') }}" width="150" height="150" id="image_preview">
                                <input style="display: none;" type='file' id="image" name="image"/>
                            </div>
                        </div>
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
                            <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                            <div class="col-md-9">
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Location")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="location" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Business Area")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="estate_name" id="estate_name" class="form-control required">
                                    <input type="hidden" name="estate_id" id="estate_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Business Area List')}}" data-url="{{route('estate.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('clinic.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store-multipart"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelected(data) {
            $('#estate_id').val(data[0].id);
            $('#estate_name').val(data[0].code + ' ' + data[0].name);
        }
    </script>
@endsection