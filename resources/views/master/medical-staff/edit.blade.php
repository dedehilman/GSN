@extends('layout', ['title' => Lang::get("Medical Staff"), 'subTitle' => Lang::get("Edit data medical staff")])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('medical-staff.update', $data->id)}}" method="POST">
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
                            <label class="col-md-3 col-form-label required">{{__("Code")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="code" class="form-control required" value="{{$data->code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Name")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control required" value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Gender")}}</label>
                            <div class="col-md-9 pt-2">
                                <div class="form-check d-inline mr-3">
                                    <input class="form-check-input" type="radio" name="gender" value="Male" @if($data->gender == 'Male') checked @endif>
                                    <label class="form-check-label">{{__("Male")}}</label>
                                </div>
                                <div class="form-check d-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="Female" @if($data->gender == 'Female') checked @endif>
                                    <label class="form-check-label">{{__("Female")}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Phone")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control" value="{{$data->phone}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Email")}}</label>
                            <div class="col-md-9">
                                <input type="text" name="email" class="form-control" value="{{$data->email}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{__("Address")}}</label>
                            <div class="col-md-9">
                                <textarea name="address" rows="4" class="form-control">{{$data->address}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tab1" role="tab" aria-selected="true">{{ __("Clinic") }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="padding-top: 10px">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <table class="table table-bordered" id="table-clinic">
                                            <thead>
                                                <tr>
                                                    <th width="10px" class="text-center">
                                                        <span class='btn btn-primary btn-sm btn-add' data-type="clinic" style="cursor: pointer"><i class='fas fa-plus-circle'></i></span>
                                                    </th>
                                                    <th>{{ __('Clinic') }}</th>
                                                    <th>{{ __('Effective Date') }}</th>
                                                    <th>{{ __('Expiry Date') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->clinics as $idx => $clinic)
                                                    <tr>
                                                        <td style="vertical-align: middle; text-align: center;">
                                                            <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                                                            <input type="hidden" class="form-control" value="{{$idx}}">
                                                            <input type="hidden" class="form-control" name="medical_staff_clinic_id[]" value="{{$clinic->id}}" id="medical-staff_clinic_id{{$idx}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="clinic_name[]" class="form-control" value="{{$clinic->clinic->name}}" id="clinic_name{{$idx}}">
                                                                <input type="hidden" name="clinic_id[]" value="{{$clinic->clinic->id}}" id="clinic_id{{$idx}}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic" data-id="clinic"><i class="fas fa-search"></i></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="effective_date[]" class="form-control date" value="{{$clinic->effective_date}}" id="effective_date{{$idx}}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                </div>
                                                                <input type="text" name="expiry_date[]" class="form-control date" value="{{$clinic->expiry_date}}" id="expiry_date{{$idx}}">
                                                            </div>
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
                        <a href="{{route('medical-staff.index')}}" class="btn btn-default"><i class="fas fa fa-undo"></i> {{__("Back")}}</a>
                        <button type="button" class="btn btn-primary" id="btn-update"><i class="fas fa fa-save"></i> {{__("Update")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="d-none" id="table-clinic-tmp">
        <tbody>
            <tr>
                <td style="vertical-align: middle; text-align: center;">
                    <span class='btn btn-danger btn-sm' onclick="removeRow(this)" style="cursor: pointer"><i class='fas fa-trash-alt'></i></span>
                    <input type="hidden" class="form-control">
                    <input type="hidden" class="form-control" name="medical_staff_clinic_id[]">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="clinic_name[]" class="form-control">
                        <input type="hidden" name="clinic_id[]">
                        <div class="input-group-append">
                            <span class="input-group-text show-modal-select" data-title="{{__('Clinic List')}}" data-url="{{route('clinic.select')}}" data-handler="onSelectedClinic" data-id="clinic"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="effective_date[]" class="form-control date">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" name="expiry_date[]" class="form-control date">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $(function(){
            $('.btn-add').on('click', function(){
                var clonedRow = $('#table-clinic-tmp tbody tr:last').clone();
                $('#table-clinic tbody').append(clonedRow);
                var textInput = clonedRow.find('input');
                
                var i = 0;
                for(var i=1; $('#medical_staff_clinic_id'+i).length;i++){}

                textInput.eq(1).attr('id', 'medical-staff_clinic_id' + i);
                textInput.eq(2).attr('id', 'clinic_name' + i);
                textInput.eq(3).attr('id', 'clinic_id' + i);
                textInput.eq(4).attr('id', 'effective_date' + i);
                textInput.eq(5).attr('id', 'expiry_date' + i);
                textInput.val('');
                textInput.eq(0).val(i);

                $('.date').datepicker({
                    fontAwesome: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    todayBtn: false,
                    clearBtn: true,
                });
            });

            $(document).on('click', '.show-modal-select', function(){
                seqId = $(this).closest('tr').find('input:first').val();
            });
        })

        function removeRow(element)
        {
            $(element).closest('tr').remove();
        }

        function onSelectedClinic(data) {
            $('#clinic_id'+seqId).val(data[0].id);
            $('#clinic_name'+seqId).val(data[0].name);
        }
    </script>
@endsection