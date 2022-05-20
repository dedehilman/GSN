<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{getParameter('APP_NAME') ?? ''}}</title>

        <link rel="shortcut icon" href="{{ getParameter('APP_FAVICON') ?? '' }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo mb-4">
                {{-- <img src="{{getParameter('APP_LOGO')}}" alt="" class="mr-2" height="75px" width="75px"> --}}
                {{getParameter('APP_NAME') ?? config('app.name')}}
            </div>
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="message">{{session()->get('success')}}</span>
                </div>
            @endif
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">{{__("You forgot your password? Here you can easily retrieve a new password")}}.</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="{{__("Username")}}" value="{{old('username')}}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="error invalid-feedback {{ $errors->has('username') ? 'd-block' : 'd-none' }}">
                                    {{ $errors->first('username') }}
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">{{__("Request new password")}}</button>
                            </div>
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <a href="{{route('login')}}">{{__("Back to login page")}}</a>
                    </p>
                </div>
            </div>
        </div>

        <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>        
        <script src="{{ asset('public/js/adminlte.min.js') }}"></script>
    </body>
</html>
