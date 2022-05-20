@extends('layout', ['title' => Lang::get("Route"), 'subTitle' => Lang::get("Create data route")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('route.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Sequence Number")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="sequence_number" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Sequence")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="sequence_name" id="sequence_name" class="form-control required">
                                    <input type="hidden" name="sequence_id" id="sequence_id" class="form-control required">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Sequence List')}}" data-url="{{route('sequence.select')}}" data-handler="onSelected"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: -10px;">
                            <label class="col-md-3 col-form-label">{{__("Route Type")}}</label>
                            <div class="col-md-9 pt-2">
                                @foreach (getRouteTypes() as $routeType)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="routeTypes[]" value="{{$routeType}}">
                                        <label class="form-check-label">{{$routeType}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('route.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
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
            $('#sequence_name').val(data[0].name);
            $('#sequence_id').val(data[0].id);
        }
    </script>
@endsection