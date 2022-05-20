@if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini')
    <nav class="main-header navbar navbar-expand @if((getAppearance()->dark_mode ?? 0) == 1) navbar-dark @else navbar-{{getAppearance()->navbar_variant ?? 'white'}} navbar-{{getAppearance()->navbar_theme ?? 'light'}} @endif @if((getAppearance()->navbar_border ?? 1) == 0) border-bottom-0 @endif">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="{{__('Search')}}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if(getNotifications()->count() > 0) <span class="badge badge-warning navbar-badge">{{getNotifications()->count()}}</span> @endif
                </a>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{getNotifications()->count()}} {{__('Notification')}}</span>
                    <div class="notification" style="overflow: auto; max-height: 300px;">
                    @foreach (getNotifications() as $notif)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('notification', $notif->id)}}" class="dropdown-item">
                            <div class="media">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{$notif->data['title'] ?? ''}}
                                    </h3>
                                    <p class="text-sm" style="margin-block-start: 0em;margin-block-end: 0em;">{{$notif->data['content'] ?? ''}}</p>
                                    <p class="text-sm text-muted" style="margin-block-start: 0em;margin-block-end: 0em;"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans()}}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="elevation-1 flag-icon @if(Config::get('app.locale') == 'en') flag-icon-us @else flag-icon-id @endif"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-0">
                    <a href="{{route('locale', 'en')}}" class="dropdown-item @if(Config::get('app.locale') == 'en') active @endif">
                        <i class="flag-icon flag-icon-us mr-2"></i> English
                    </a>
                    <a href="{{route('locale', 'id')}}" class="dropdown-item @if(Config::get('app.locale') == 'id') active @endif">
                        <i class="flag-icon flag-icon-id mr-2"></i> Indonesia
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{getCurrentUser()->name ?? ''}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header bg-primary">
                        <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" class="img-circle elevation-2" alt="User Image">
                        <p>
                            {{getCurrentUser()->name ?? ''}}
                            <small></small>
                        </p>
                    </li>
                    <a href="#" class="dropdown-item" data-widget="fullscreen">
                        <i class="fas fa-expand-arrows-alt mr-2"></i> {{ __('Full Screen') }}</span>
                    </a>
                    <a href="{{route('appearance-setting')}}" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> {{ __('Setting') }}</span>
                    </a>
                    <a href="{{route('change-password')}}" class="dropdown-item">
                        <i class="fas fa-lock mr-2"></i> {{ __('Change Password') }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Sign Out') }}</span>
                    </a>
                </ul>
            </li>
        </ul>
    </nav>
@else
    <nav class="main-header navbar navbar-expand-md @if((getAppearance()->dark_mode ?? 0) == 1) navbar-dark @else navbar-{{getAppearance()->navbar_variant ?? 'dark'}} navbar-{{getAppearance()->navbar_theme ?? 'dark'}} @endif @if((getAppearance()->navbar_border ?? 1) == 0) border-bottom-0 @endif">    
        <div class="container">
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <ul class="navbar-nav">
                    {!! getMenu(session('menu')) !!}
                </ul>
            </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="{{__('Search')}}" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        @if(getNotifications()->count() > 0) <span class="badge badge-warning navbar-badge">{{getNotifications()->count()}}</span> @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{getNotifications()->count()}} {{__('Notification')}}</span>
                        <div class="notification" style="overflow: auto; max-height: 300px;">
                        @foreach (getNotifications() as $notif)
                            <div class="dropdown-divider"></div>
                            <a href="{{route('notification', $notif->id)}}" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            {{$notif->data['title'] ?? ''}}
                                        </h3>
                                        <p class="text-sm" style="margin-block-start: 0em;margin-block-end: 0em;">{{$notif->data['content'] ?? ''}}</p>
                                        <p class="text-sm text-muted" style="margin-block-start: 0em;margin-block-end: 0em;"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans()}}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="elevation-1 flag-icon @if(Config::get('app.locale') == 'en') flag-icon-us @else flag-icon-id @endif"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-0">
                        <a href="{{route('locale', 'en')}}" class="dropdown-item @if(Config::get('app.locale') == 'en') active @endif">
                            <i class="flag-icon flag-icon-us mr-2"></i> English
                        </a>
                        <a href="{{route('locale', 'id')}}" class="dropdown-item @if(Config::get('app.locale') == 'id') active @endif">
                            <i class="flag-icon flag-icon-id mr-2"></i> Indonesia
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{getCurrentUser()->name ?? ''}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                {{getCurrentUser()->name ?? ''}}
                                <small></small>
                            </p>
                        </li>
                        <a href="#" class="dropdown-item" data-widget="fullscreen">
                            <i class="fas fa-expand-arrows-alt mr-2"></i> {{ __('Full Screen') }}</span>
                        </a>
                        <a href="{{route('appearance-setting')}}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> {{ __('Setting') }}</span>
                        </a>
                        <a href="{{route('change-password')}}" class="dropdown-item">
                            <i class="fas fa-lock mr-2"></i> {{ __('Change Password') }}</span>
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Sign Out') }}</span>
                        </a>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
@endif