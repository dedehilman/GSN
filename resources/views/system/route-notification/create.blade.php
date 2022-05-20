@extends('layout', ['title' => Lang::get("Route Notification"), 'subTitle' => Lang::get("Create data route notification")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('route.notification.store', ['parentId'=>$data->id])}}" method="POST">
                @csrf
                <input type="hidden" name="route_id" value="{{$data->id}}">
                
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
                            <label class="col-md-3 col-form-label required">{{__("Trigger")}}</label>
                            <div class="col-md-9">
                                <select name="workflow_trigger" class="custom-select required">
                                    @foreach (getWorkflowTrigger() as $trigger)
                                        <option value="{{$trigger}}">{{$trigger}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Recipient")}}</label>
                            <div class="col-md-9">
                                <select name="workflow_recipient" class="custom-select required">
                                    @foreach (getWorkflowRecipient() as $recipient)
                                        <option value="{{$recipient}}">{{$recipient}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Notification Template")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="notification_template_name" id="notification_template_name" class="form-control required">
                                    <input type="hidden" name="notification_template_id" id="notification_template_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Notification Template List')}}" data-url="{{route('notification-template.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('route.notification.index', ['parentId'=>$data->id])}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelected(data) {
            $('#notification_template_id').val(data[0].id);
            $('#notification_template_name').val(data[0].name);
        }
    </script>
@endsection