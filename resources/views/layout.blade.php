<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$page_title ?? getParameter('APP_NAME') ?? ''}}</title>

        <link rel="shortcut icon" href="{{ getParameter('APP_FAVICON') ?? '' }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/datatables-select/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <style>
            .table td, .table th {
                padding: .4rem;
            }
            .view .btn:not(:disabled):not(.disabled).active, .btn:not(:disabled):not(.disabled):active {
                background-color: #e6e6e6;
                border-color: #bababa;
                box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            }
            .dark-mode .view .btn:not(:disabled):not(.disabled).active, .btn:not(:disabled):not(.disabled):active {
                background-color: #848484;
                border-color: #848484;
                box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            }
            .view .btn.btn-default[aria-expanded="true"]{
                background-color: #e6e6e6;
                border-color: #bababa;
                box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            }
            .dark-mode .view .btn.btn-default[aria-expanded="true"]{
                background-color: #848484;
                border-color: #848484;
                box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            }
            #datatable tbody td {
                cursor: pointer;
            }
            label.required::after {
                content: '*';
                color: red;
                padding-left: 5px;
                font-weight: normal;
            }
            .show-modal-select {
                cursor: pointer;
            }
            #image_preview {
                cursor: pointer;
            }
            .datepicker {
                padding: 5px;
            }
            .sidebar-mini.text-sm .main-sidebar .nav-child-indent .nav-treeview .nav-link {
                width: calc(250px - .5rem * 2 - .5rem);
            }
            .control-sidebar-title {
                font-size: 16px;
                font-weight: bold;
            }
            .text-sm .select2-container--default .select2-selection--single, select.form-control-sm~.select2-container--default .select2-selection--single {
                height: calc(1.8125rem + 8px);
            }
            .text-sm .select2-container--default .select2-selection--single .select2-selection__arrow, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__arrow {
                margin-top: 0rem;
            }
            .text-sm .select2-container--default .select2-selection--single .select2-selection__rendered, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__rendered {
                top: 0rem;
            }
            #fileUploaderContainer .error {
                padding-left: 10px;
                padding-top: 5px;
            }
            .dt-buttons {
                display: none;
            }
        </style>
        @yield('style')
    </head>
    <body class="hold-transition {{getAppearance()->layout ?? 'sidebar-mini'}} @if((getAppearance()->sidebar_fixed ?? 1) == 1) layout-fixed @endif @if((getAppearance()->navbar_fixed ?? 1) == 1) layout-navbar-fixed @endif @if((getAppearance()->footer_fixed ?? 1) == 1) layout-footer-fixed @endif @if((getAppearance()->dark_mode ?? 0) == 1) dark-mode @endif @if((getAppearance()->small_text ?? 1) == 1) text-sm @endif">
        <div class="wrapper">
            @include('partials.navbar')

            @if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini')
                @include('partials.sidebar')
            @endif

            <div class="content-wrapper">
                <div class="content-header">
                    @if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini')
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h1 class="m-0">{{$title ?? ''}}</h1>
                                    <small>{{$subTitle ?? ''}}</small>
                                </div>
                                <div class="col-sm-6">
                                    {!! Breadcrumbs::render(Route::currentRouteName(), $data ?? '') ?? '' !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="m-0">{{$title ?? ''}}</h1>
                                        <small>{{$subTitle ?? ''}}</small>
                                    </div>
                                    <div class="col-sm-6">
                                        {!! Breadcrumbs::render(Route::currentRouteName(), $data ?? '') ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="content">
                    @if((getAppearance()->layout ?? 'sidebar-mini') == 'sidebar-mini')
                        <div class="container-fluid">
                            @include('partials.notification')

                            @yield('content')
                        </div>
                    @else
                        <div class="container">
                            <div class="container-fluid">
                                @include('partials.notification')

                                @yield('content')
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            @include('partials.footer')
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <div class="modal fade" id="modal-select" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="button" class="btn btn-primary" id="btn-select">{{__('Select')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" data-backdrop="static" tabindex="-1" role="dialog" id="loader" data-keyboard="false">
            <div class="modal-dialog text-center" style="top:50%;">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
        </div>

        <div id="modal-form-container"></div>

        <aside class="control-sidebar control-sidebar-light">
            <div class="row">
                <div class="col-12 d-flex justify-content-between pr-4 pt-3 pb-3 pl-4">
                    <span class="control-sidebar-title"></span>
                    <a data-widget="control-sidebar" data-slide="true" href="#" role="button" style="color: black;">&times;</a>
                </div>
            </div>      
            <hr class="m-0"/>     
            <div class="control-sidebar-body p-3">
            </div> 
        </aside>

        <div class="modal fade" id="modal-send-to-email" aria-hidden="true" >
            <div class="modal-dialog modal-sm">
                <form id="sendToEmailForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{__("Send to Email")}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="required">{{__("Receiver Name")}}</label>
                                <input type="text" name="name" class="form-control required">
                            </div>
                            <div class="form-group">
                                <label class="required">{{__("Email")}}</label>
                                <input type="email" name="email" class="form-control required">
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="button" class="btn btn-primary send-to-email-send">{{__('Send')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>        
        <script src="{{ asset('public/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('public/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-select/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
        <script src="{{ asset('public/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('public/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('public/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script src="{{ asset('public/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('public/js/crud-handler.js') }}"></script>
        <script src="{{ asset('public/js/select-handler.js') }}"></script>
        <script>
            $messages = [
                "{{__('Something went wrong')}}",
                "{{__('This field is required')}}",
                "{{__('Yes')}}",
                "{{__('Cancel')}}",
                "{{__('Are you sure')}}",
                "{{__('You wont be able to revert this')}}",
                "{{__('Progress of action handling has not yet reached 100%')}}",
                "{{__('Continue the process ?')}}",
            ];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            
            $.extend(true, $.fn.dataTable.defaults, {
                dom: "B<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'wrapper'rt><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                destroy : true,
                searching: false,
                ordering: true,
                order: [[3, "asc"]],
                select: "multiple",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, '{{__("All")}}']],
                language: {
                    'lengthMenu': '{{__("_MENU_ Entries")}}',
                    'info': '{{__("Showing _START_ to _END_ of _TOTAL_ entries")}}',
                    'processing': '{{__("Processing...")}}',
                    'search': '{{__("Search:")}}',
                    'infoEmpty': '{{__("Showing 0 to 0 of 0 entries")}}',
                    'infoFiltered': '{{__("(filtered from _MAX_ total entries)")}}',
                    'zeroRecords': '{{__("No matching records found")}}',
                    'paginate': {
                        'first': '{{__("First")}}',
                        'last': '{{__("Last")}}',
                        'next': '{{__("Next")}}',
                        'previous': '{{__("Previous")}}',
                    },
                    'select': {
                        'rows': {
                            _: '{{__("%d rows selected")}}',
                            0: '',
                        },
                    },
                },
                // dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{$title ?? "Data Export"}}',
                    },
                    {
                        extend: 'csv',
                        title: '{{$title ?? "Data Export"}}',
                    },
                    {
                        extend: 'pdf',
                        title: '{{$title ?? "Data Export"}}',
                    }
                ]
            });

            function showNotification($status, $message)
            {
                if(Array.isArray($message)) {
                    $message = $message.join('<br/>');
                }

                if($status == '200')
                {
                    $('.notification.notification-success .message').html($message);
                    $('.notification.notification-success').removeClass('d-none');
                }
                else if($status == '500')
                {
                    $('.notification.notification-danger .message').html($message);
                    $('.notification.notification-danger').removeClass('d-none');
                }
                else
                {
                    $('.notification.notification-info .message').html($message);
                    $('.notification.notification-info').removeClass('d-none');
                }
            }

            $(function() {
                $column = [3];
                $("#image_preview").click(function() {
                    $("#image").click();
                });

                $("#image").change(function() {
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image_preview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });

                $('.date').datepicker({
                    fontAwesome: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    todayBtn: false,
                    clearBtn: true,
                });

                $('.select2').select2();
                bsCustomFileInput.init();

                $('.modal').on('shown.bs.modal', function() {
                    zIndexModal = 1050;
                    zIndexBackdrop = 1040;
                    $(this).css("z-index", zIndexModal + ($(".modal-backdrop").length * 10));
                    $(".modal-backdrop").each(function(index) {
                        $(this).css("z-index", zIndexBackdrop + (index * 10));
                    });
                });

                $(".send-to-email").on('click', function(){
                    $("#sendToEmailForm").attr('action', $(this).attr('data-href'));
                    $("#sendToEmailForm input[name='email']").val('');
                    $("#sendToEmailForm input[name='name']").val('');
                    $("#modal-send-to-email").modal('show');
                });

                $(".send-to-email-send").on('click', function(){
                    if(validateForm($(this))) {
                        $("#modal-send-to-email").modal('hide');
                        var href = $(this).closest('form')[0].action;
                        href = href + "&email=" + $("#sendToEmailForm input[name='email']").val() + "&name=" + $("#sendToEmailForm input[name='name']").val();
                        window.location.href = href;
                    }
                });
            });
        </script>
        @if (Session::has('info'))
            <script>
                showNotification('400', '{{Session::get("info")}}')
            </script>
        @elseif(Session::has('success'))
            <script>
                showNotification('200', '{{Session::get("success")}}')
            </script>
        @endif
        @yield('script')
    </body>
</html>