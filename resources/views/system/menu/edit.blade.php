@extends('layout', ['title' => Lang::get("Menu"), 'subTitle' => Lang::get("Edit data menu")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('menu.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Title")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="title" class="form-control required" value="{{$data->title}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Class")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="class" class="form-control" value="{{$data->class}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Nav Header")}}</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nav_header" value="1" @if($data->nav_header == 1) checked @endif>
                                    <label class="form-check-label">{{__("Yes")}}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nav_header" value="0" @if($data->nav_header == 0) checked @endif>
                                    <label class="form-check-label">{{__("No")}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Link")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="link" class="form-control required" value="{{$data->link}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Sequence")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="sequence" class="form-control required" value="{{$data->sequence}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Display")}}</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="display" value="1" @if($data->display == 1) checked @endif>
                                    <label class="form-check-label">{{__("Yes")}}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="display" value="0" @if($data->display == 0) checked @endif>
                                    <label class="form-check-label">{{__("No")}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Parent")}}</label>
                            <div class="col-md-9">
                                <div class="input-group mb-3">
                                    <input type="text" name="parent_id" id="parent_id" class="form-control" value="{{$data->parent_id}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Menu List')}}" data-url="{{route('menu.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('menu.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelected(data) {
            $('#parent_id').val(data[0].code);
        }
    </script>
@endsection