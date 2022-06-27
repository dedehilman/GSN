@extends('layout', ['title' => Lang::get("Employee"), 'subTitle' => Lang::get("View data employee")])

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
                        <label class="col-md-3 col-form-label">{{__("Code")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->code}}</div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{__("Name")}}</label>
                        <div class="col-md-9 col-form-label">{{$data->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Company") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="true">{{ __("Department") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="true">{{ __("Position") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab4" role="tab" aria-selected="true">{{ __("Attribute") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab5" role="tab" aria-selected="true">{{ __("Relationship") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#tab6" role="tab" aria-selected="true">{{ __("Afdelink") }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" style="padding-top: 10px">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <table class="table table-bordered" id="table-company">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Company') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->companies as $company)
                                                <tr>
                                                    <td>{{$company->company->name}}</td>
                                                    <td>{{$company->effective_date}}</td>
                                                    <td>{{$company->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($company->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <table class="table table-bordered" id="table-department">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Department') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->departments as $department)
                                                <tr>
                                                    <td>{{$department->department->name}}</td>
                                                    <td>{{$department->effective_date}}</td>
                                                    <td>{{$department->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($department->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel">
                                    <table class="table table-bordered" id="table-position">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Position') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->positions as $position)
                                                <tr>
                                                    <td>{{$position->position->name}}</td>
                                                    <td>{{$position->effective_date}}</td>
                                                    <td>{{$position->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($position->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab4" role="tabpanel">
                                    <table class="table table-bordered" id="table-attribute">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Attribute') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->attributes as $attribute)
                                                <tr>
                                                    <td>{{$attribute->attribute->name}}</td>
                                                    <td>{{$attribute->effective_date}}</td>
                                                    <td>{{$attribute->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($attribute->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab5" role="tabpanel">
                                    <table class="table table-bordered" id="table-relationship">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Relationship') }}</th>
                                                <th>{{ __('Identity Number') }}</th>
                                                <th>{{ __('Name') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->relationships as $relationship)
                                                <tr>
                                                    <td>{{$relationship->relationship->name}}</td>
                                                    <td>{{$relationship->identity_number}}</td>
                                                    <td>{{$relationship->name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="tab6" role="tabpanel">
                                    <table class="table table-bordered" id="table-afdelink">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Afdelink') }}</th>
                                                <th>{{ __('Effective Date') }}</th>
                                                <th>{{ __('Expiry Date') }}</th>
                                                <th>{{ __('Default') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->afdelinks as $afdelink)
                                                <tr>
                                                    <td>{{$afdelink->afdelink->name}}</td>
                                                    <td>{{$afdelink->effective_date}}</td>
                                                    <td>{{$afdelink->expiry_date}}</td>
                                                    <td class="text-center">
                                                        @if ($afdelink->is_default == 1)
                                                            <span class="badge badge-primary">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{route('employee.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection