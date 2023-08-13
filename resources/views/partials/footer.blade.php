<footer class="main-footer">
    <strong>Copyright &copy; Dede Hilman 202043570013 {{ now()->year }}. </strong>
    <div class="float-right d-none d-sm-block">
        <b>{{__('Version')}}</b> {{getParameter('APP_VERSION') ?? config('app.version')}}
    </div>
</footer>