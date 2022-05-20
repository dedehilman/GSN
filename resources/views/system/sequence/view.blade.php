@extends('layout', ['title' => Lang::get("Sequence"), 'subTitle' => Lang::get("View data sequence")])

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
                        <label class="col-md-3 col-form-label">{{__("Format")}}</label>
                        <div class="col-md-9 col-form-label">
                            {{$data->format}} <i class="fas fa-question-circle ml-1" data-toggle="popover"></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Number Increment")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->number_increment}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Number Next")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->number_next}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Use Date Range")}}</label>
                        <div class="col-md-9 col-form-label">
                            @if ($data->use_date_range == 1)
                                <span class="badge badge-primary">{{ __('Yes') }}</span>
                            @else
                                <span class="badge badge-danger">{{ __('No') }}</span>
                            @endif
                        </div>
                    </div>

                    @if($data->use_date_range == 1 && (getCurrentUser()->can('sequence-period-create') || getCurrentUser()->can('sequence-period-edit') || getCurrentUser()->can('sequence-period-list') || getCurrentUser()->can('sequence-period-delete')))
                        <a href="{{route('sequence.period.index', $data->id)}}">{{__('Period Information Detail')}}</a>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('sequence.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>

    <div id="template-popover" style="font-size: 11px" class="d-none">
        <table>
            <tr>
                <th>Code</th>
                <th>Example</th>
                <th>Description</th>
            </tr>
            <tr>
                <th>{D}</th>
                <td>5</td>
                <td>Day of month number (from 1 to 31)</td>
            </tr>
            <tr>
                <th>{DD}</th>
                <td>05</td>
                <td>Day of month number with trailing zero (from 01 to 31)</td>
            </tr>
            <tr>
                <th>{dd}</th>
                <td>Th</td>
                <td>Minified day name (from Su to Sa), transatable</td>
            </tr>
            <tr>
                <th>{ddd}</th>
                <td>Thu</td>
                <td>Short day name (from Sun to Sat), transatable</td>
            </tr>
            <tr>
                <th>{dddd}</th>
                <td>Thursday</td>
                <td>Day name (from Sunday to Saturday), transatable</td>
            </tr>
            <tr>
                <th>{M}</th>
                <td>1</td>
                <td>Month of month number (from 1 to 31)</td>
            </tr>
            <tr>
                <th>{MM}</th>
                <td>01</td>
                <td>Month with trailing zero (from 01 to 12)</td>
            </tr>
            <tr>
                <th>{MMM}</th>
                <td>Jan</td>
                <td>Short month name, transatable</td>
            </tr>
            <tr>
                <th>{MMMM}</th>
                <td>January</td>
                <td>Month name, transatable</td>
            </tr>
            <tr>
                <th>{YY}</th>
                <td>20</td>
                <td>Year on 2 digits from 00 to 99</td>
            </tr>
            <tr>
                <th>{YYYY}</th>
                <td>2020</td>
                <td>Year on 4 digits from 0000 to 9999</td>
            </tr>
            <tr>
                <th>{N-SEQ}</th>
                <td>001</td>
                <td>Sequence number with trailing n-digits zero</td>
            </tr>
            <tr>
                <th>{X}</th>
                <td>IX</td>
                <td>Month number in romawi from I to XII</td>
            </tr>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $('document').ready(function(){

            $('[data-toggle="popover"]').popover({
                html: true,
                title: 'Info',
                content: function() {
                    var el = $('#template-popover').clone();
                    return el.removeClass('d-none');
                },
                placement: 'top',
            });

            $('body').on('click', function (e) {
                if ($(e.target).data('toggle') !== 'popover'
                    && $(e.target).parents('.popover.in').length === 0) { 
                    $('[data-toggle="popover"]').popover('hide');
                }
            });
        });
    </script>
@endsection