<footer class="main-footer">
    <strong>Copyright &copy; {{ now()->year }}. </strong> All rights reserved.
    <div class="float-right d-none d-sm-block">
        <b>{{__('Version')}}</b> {{getParameter('APP_VERSION') ?? config('app.version')}}
    </div>
</footer>