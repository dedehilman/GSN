@extends('layout', ['title' => Lang::get("Sick Letter"), 'subTitle' => Lang::get("View data sick letter")])

@section('content')
    <div class="row">
        <div class="col-md-12">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Transaction No Ref")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->referenceTransaction()->transaction_no ?? ""}}</div>
                            </div>
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
                                <label class="col-md-4 col-form-label">{{__("Num Of Days")}}</label>
                                <div class="col-md-8 col-form-label">{{$data->num_of_days}}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Diagnosis")}}</label>
                                <div class="col-md-8">
                                    <table class="table table-bordered mt-2" id="table-diganosis">
                                        <thead>
                                            <tr>
                                                <th>{{__('Diagnosis')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->diagnoses as $diagnosis)
                                            <tr>
                                                <td>{{$diagnosis->code.' - '.$diagnosis->name}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">{{__("Remark")}}</label>
                                <div class="col-md-8 col-form-label">{!!nl2br($data->remark)!!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="btn-group">
                        <a href="{{route('sick-letter.download', $data->id)}}" class="btn btn-default"><i class="fas fa fa-print"></i> {{__("Download")}}</a>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" href="{{route('sick-letter.download', $data->id)}}">{{__('Download')}}</a>
                            <a class="dropdown-item" href="{{route('sick-letter.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}}</a>
                            <a class="dropdown-item send-to-email" href="#" data-href="{{route('sick-letter.send-to-email', 'id='.$data->id)}}">{{__('Send to Email')}} ...</a>
                        </div>
                    </div>
                    <a href="{{route('sick-letter.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection