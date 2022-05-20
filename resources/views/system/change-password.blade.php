@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('change-password.store')}}" method="POST">
                @csrf
                <input type="hidden" name="type" value="database">

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
                            <label class="col-md-3 col-form-label required">{{__("Current Password")}}</label>
                            <div class="col-md-9">
                                <input type="password" name="current_password" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("New Password")}}</label>
                            <div class="col-md-9">
                                <input type="password" name="new_password" class="form-control required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label required">{{__("Confirm New Password")}}</label>
                            <div class="col-md-9">
                                <input type="password" name="new_confirm_password" class="form-control required">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary" id="btn-store"><i class="fas fa fa-save"></i> {{__("Save")}}</button>
                        @if (getParameter('LDAP_AUTH') == 'true')
                            <button type="button" class="btn btn-default" id="btn-store-ldap"><i class="fas fa fa-save"></i> {{__("Save LDAP")}}</button>                            
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $("#btn-store-ldap").on('click', function(){
                $("input[type='hidden'][name='type']").val('ldap');
                $("#btn-store").trigger('click');    
            });

            $("#btn-store").on('click', function(){
                $("input[type='hidden'][name='type']").val('database');
            });
        });
    </script>
@endsection