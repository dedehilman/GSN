@extends('layout', ['title' => Lang::get("Plano Test"), 'subTitle' => Lang::get("Edit data plano test")])

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('action.plano-test.update', $data->id)}}" method="POST">
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
                                            <label class="col-md-2 col-form-label required">{{__("Result")}}</label>
                                            <div class="col-md-4">
                                                <select name="result" class="form-control custom-select required">
                                                    <option value=""></option>
                                                    <option value="Positive" @if($data->result == 'Positive') selected @endif>{{__("Positive")}}</option>
                                                    <option value="Negative" @if($data->result == 'Negative') selected @endif>{{__("Negative")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label required">{{__("Pregnancy Num")}}</label>
                                            <div class="col-md-4">
                                                <input type="number" name="pregnancy_num" class="form-control required" value="{{$data->pregnancy_num}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{__("Remark")}}</label>
                                            <div class="col-md-4">
                                                <textarea name="remark" rows="4" class="form-control">{{$data->remark}}</textarea>
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
                        <a href="{{route('action.plano-test.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <div class="btn-group">
                            <a href="{{route('action.plano-test.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="{{route('action.plano-test.download', $data->id)}}">{{__('Download')}}</a>
                                <a class="dropdown-item" href="{{route('action.plano-test.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}}</a>
                                <a class="dropdown-item send-to-email" href="#" data-href="{{route('action.plano-test.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}} ...</a>
                            </div>
                        </div>
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
        MEDIA_URL = "{{route('action.plano-test.store-media')}}"; 

        $(function(){
        });
    </script>
    @yield("scriptDiagnosis")
    @yield("scriptPresciption")
    @yield("scriptAction")
    @yield("scriptHistory")
    @yield("scriptOther")
@endsection

