<aside class="main-sidebar sidebar-{{getAppearance()->sidebar_theme ?? 'dark'}}-{{getAppearance()->sidebar_variant ?? 'primary'}} elevation-{{getAppearance()->sidebar_elevation ?? 1}}">
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{getParameter('APP_LOGO')}}" alt="" class="brand-image img-circle elevation-1" style="opacity: .8">
        <span class="brand-text font-weight-light">{{getParameter('APP_NAME') ?? config('app.name')}}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(getAppearance()->image ?? 'public/img/user/default.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('appearance-setting')}}" class="d-block">{{getCurrentUser()->name ?? ''}}</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column @if((getAppearance()->sidebar_legacy ?? 0) == 1)nav-legacy @endif @if((getAppearance()->sidebar_flat ?? 0) == 1)nav-flat @endif @if((getAppearance()->sidebar_indent ?? 1) == 1)nav-child-indent @endif" data-widget="treeview" role="menu" data-accordion="false">
                {!! getMenu(session('menu')) !!}
            </ul>
        </nav>
    </div>
</aside>