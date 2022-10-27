@extends('layout', ['title' => Lang::get("Media"), 'subTitle' => Lang::get("Create data media")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('media.store')}}" method="POST">
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
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right">
                                <span class="btn btn-primary fileinput-button">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>{{__('Upload File')}}</span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                @include('partials/file-upload-preview')
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('media.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('public/js/file-upload-handler.js') }}"></script>
    <script>
        MEDIA_URL = "{{route('action.work-accident.store-media')}}"; 
    </script>
@endsection