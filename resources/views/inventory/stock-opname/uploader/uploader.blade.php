@extends('layout', ['title' => Lang::get("Stock Opname Uploader"), 'subTitle' => Lang::get("Upload data stock opname")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('stock-opname.uploader.upload')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="upl_no" value="{{getUplNo()}}">
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
                            <label class="col-md-3 col-form-label required">{{__("File")}}</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file">
                                        <label class="custom-file-label">{{__("Choose File")}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ asset('public/Stock Opname Upl - Template.xlsx') }}" target="_BLANK" class="btn btn-default"><i class="fas fa fa-download"></i> {{__("Download Template")}}</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa fa-upload"></i> {{__("Upload")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection