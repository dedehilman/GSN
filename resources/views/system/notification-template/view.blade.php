@extends('layout', ['title' => Lang::get("Notification Template"), 'subTitle' => Lang::get("View data notification template")])

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
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Subject")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->subject}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Body")}}</label>
                        <div class="col-md-9 col-form-label">{!!$data->body!!}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Notification Type")}}</label>
                        <div class="col-md-9 pt-2">
                            [
                            @foreach ($data->notificationTypes as $index => $notificationType)
                                @if ($index > 0),@endif
                                {{$notificationType->notification_type}}
                            @endforeach
                            ]
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('notification-template.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection