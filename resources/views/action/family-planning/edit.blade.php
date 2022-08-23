@extends('layout', ['title' => Lang::get("Family Planning"), 'subTitle' => Lang::get("Edit data family planning")])

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('action.family-planning.update', $data->id)}}" method="POST">
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
                                    <div class="col-md-8 col-form-label">({{$data->reference_type}}) {{$data->reference_type == 'Internal' ? $data->referenceClinic->name : $data->reference->name}}</div>
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
                                            <label class="col-md-2 col-form-label required">{{__("Family Planning Category")}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="family_planning_category_name" class="form-control required" value="{{$data->familyPlanningCategory->name ?? ''}}" readonly>
                                                    <input type="hidden" name="family_planning_category_id" id="family_planning_category_id" value="{{$data->familyPlanningCategory->id ?? ''}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text show-modal-select" data-title="{{__('Family Planning Category List')}}" data-url="{{route('family-planning-category.select')}}" data-handler="onSelectedFamilyPlanningCategory"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label required">{{__("Installation Date")}}</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input type="text" name="installation_date" class="form-control required date" value="{{$data->installation_date ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                                            <div class="col-md-4">
                                                <textarea name="remark" rows="4" class="form-control">{{$data->remark}}</textarea>
                                            </div>
                                        </div>
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
                        <a href="{{route('action.family-planning.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
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
        MEDIA_URL = "{{route('action.family-planning.store-media')}}"; 

        $(function(){
        });

        function onSelectedFamilyPlanningCategory(data) {
            $('#family_planning_category_id').val(data[0].id);
            $('#family_planning_category_name').val(data[0].name);
        }
    </script>
    @yield("scriptPresciption")
    @yield("scriptAction")
    @yield("scriptOther")
@endsection

