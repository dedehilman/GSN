@extends('layout', ['title' => Lang::get("Stock"), 'subTitle' => Lang::get("Create data stock report")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('report.stock.store')}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Period")}}</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="period_name" id="period_name" class="form-control required" readonly>
                                    <input type="hidden" name="period_id" id="period_id">
                                    <div class="input-group-append">
                                        <span class="input-group-text show-modal-select" data-title="{{__('Period List')}}" data-url="{{route('period.select')}}" data-handler="onSelectedPeriod"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{route('report.stock.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function onSelectedPeriod(data) {
            $('#period_id').val(data[0].id);
            $('#period_name').val(data[0].name);
        }
    </script>
@endsection