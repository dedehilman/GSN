@extends('layout', ['title' => Lang::get("Route"), 'subTitle' => Lang::get("View data route")])

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
                        <label class="col-md-3 col-form-label">{{__("Sequence Number")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->sequence_number}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Sequence")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->sequence->name}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Route Type")}}</label>
                        <div class="col-md-9 pt-2">
                            [
                            @foreach ($data->routeTypes as $index => $routeType)
                                @if ($index > 0),@endif
                                {{$routeType->route_type}}
                            @endforeach
                            ]
                        </div>
                    </div>
                    @if(getCurrentUser()->can('node-create') || getCurrentUser()->can('node-edit') || getCurrentUser()->can('node-list') || getCurrentUser()->can('node-delete'))
                        <a href="{{route('route.node.index', $data->id)}}">{{__('Node Information Detail')}}</a>
                    @endif
                    @if(getCurrentUser()->can('route-notification-create') || getCurrentUser()->can('route-notification-edit') || getCurrentUser()->can('route-notification-list') || getCurrentUser()->can('route-notification-delete'))
                        <a class="d-block mt-3" href="{{route('route.notification.index', ['parentId'=>$data->id])}}">{{__('Notification Information Detail')}}</a>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('route.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection