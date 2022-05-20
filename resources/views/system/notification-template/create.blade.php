@extends('layout', ['title' => Lang::get("Notification Template"), 'subTitle' => Lang::get("Create data notification template")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('notification-template.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Subject")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="subject" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Body")}}</label>
                            <div class="col-md-9">
                                <textarea name="body" rows="10" class="form-control required"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: -10px;">
                            <label class="col-md-3 col-form-label">{{__("Notification Type")}}</label>
                            <div class="col-md-9 pt-2">
                                @foreach (getNotificationTypes() as $notificationType)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="notificationTypes[]" value="{{$notificationType}}">
                                        <label class="form-check-label">{{$notificationType}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('notification-template.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection