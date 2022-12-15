@extends('layout', ['title' => Lang::get("Work Accident"), 'subTitle' => Lang::get("Edit data work accident")])

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('action.work-accident.update', $data->id)}}" method="POST">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Patient")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->patient->name}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("For Relationship")}}</label>
                                    <div class="col-md-8 col-form-label">
                                        @if ($data->for_relationship == 1)
                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row @if($data->for_relationship == 0) d-none @endif">
                                    <label class="col-md-4 col-form-label">{{__("Relationship")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->patientRelationship->name ?? ''}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Place / Date Birth")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->for_relationship == 0 ? $data->patient->birth_place.' / '.$data->patient->birth_date : $data->patientRelationship->birth_place.' / '.$data->patientRelationship->birth_date}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Gender / Old")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->for_relationship == 0 ? Lang::get($data->patient->gender).' / '.getAge($data->patient->birth_date) : Lang::get($data->patientRelationship->gender).' / '.getAge($data->patientRelationship->birth_date)}} {{__("Year")}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Transaction No")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->transaction_no}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Transaction Date")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->transaction_date}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Clinic")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->clinic->name}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Medical Staff")}}</label>
                                    <div class="col-md-8 col-form-label">{{$data->medicalStaff->name}}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{__("Reference")}}</label>
                                    <div class="col-md-8 col-form-label">{{__($data->reference_type)}} {{$data->reference_type == 'Internal' ? $data->referenceClinic->name : ($data->reference_type == 'External' ? $data->reference->name : '')}}</div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("General") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab8" role="tab" aria-selected="true">{{ __("Diagnosis") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="true">{{ __("Prescription") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab4" role="tab" aria-selected="true">{{ __("Action") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab5" role="tab" aria-selected="true">{{ __("History") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab6" role="tab" aria-selected="true">{{ __("Attachment") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tab7" role="tab" aria-selected="true">{{ __("Other") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label required">{{__("Work Accident Category")}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="work_accident_category_name" class="form-control required" value="{{$data->workAccidentCategory->name ?? ''}}" readonly>
                                                    <input type="hidden" name="work_accident_category_id" id="work_accident_category_id" value="{{$data->workAccidentCategory->id ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text show-modal-select" data-title="{{__('Work Accident Category List')}}" data-url="{{route('work-accident-category.select')}}" data-handler="onSelectedWorkAccidentCategory"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-2">
                                            <label class="col-md-2 col-form-label required">{{__("Exposure")}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="exposure_name" class="form-control required" value="{{$data->exposure->name ?? ''}}" readonly>
                                                    <input type="hidden" name="exposure_id" id="exposure_id" value="{{$data->exposure->id ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text show-modal-select" data-title="{{__('Exposure List')}}" data-url="{{route('exposure.select')}}" data-handler="onSelectedExposure"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label required">{{__("Accident Date")}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="text" name="accident_date" class="form-control required date" value="{{$data->accident_date ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label required">{{__("Accident Location")}}</label>
                                            <div class="col-md-4">
                                                <input type="text" name="accident_location" class="form-control required" value="{{$data->accident_location ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{__("Short Description")}}</label>
                                            <div class="col-md-4">
                                                <textarea name="short_description" maxlength="255" rows="4" class="form-control">{{$data->short_description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{__("Description")}}</label>
                                            <div class="col-md-4">
                                                <textarea name="description" rows="4" class="form-control">{{$data->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab8" role="tabpanel">
                                        @include('action.diagnosis-edit')
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        @include('action.prescription-edit')
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        @include('action.action-edit')
                                    </div>
                                    <div class="tab-pane fade" id="tab5" role="tabpanel">
                                        @include('action.history-view')
                                    </div>
                                    <div class="tab-pane fade pt-3" id="tab6" role="tabpane2">
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
                                                @include('partials/file-upload-preview', ["media" => $data->getMedia("media")])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab7" role="tabpanel">
                                        @include('action.other-edit')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('action.work-accident.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
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

        $(function(){
        });

        function onSelectedWorkAccidentCategory(data) {
            $('#work_accident_category_id').val(data[0].id);
            $('#work_accident_category_name').val(data[0].name);
        }

        function onSelectedExposure(data) {
            $('#exposure_id').val(data[0].id);
            $('#exposure_name').val(data[0].name);
        }
    </script>
    @yield("scriptDiagnosis")
    @yield("scriptPresciption")
    @yield("scriptAction")
    @yield("scriptHistory")
    @yield("scriptOther")
@endsection

