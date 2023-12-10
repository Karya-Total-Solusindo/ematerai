<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/img/favicon.png') }}">
    <title>
        {{ env('APP_NAME') }}
    </title>
    <!-- jQuery 3 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="{{ asset('assets/js/plugins/fontawesome_42d5adcbca.js') }}" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset("assets/js/plugins/pdf/pdf.js") }}" type="module"></script> --}}
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js" integrity="sha512-59swnhUs+9AinrKlTPqsoO5ukNPPFbPXFyaf41MAgiTG/fv3LBZwWQWiZNYeksneLhiUo4xjh/leTZ53sZzQ4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- toastr js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{--  jsTree --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    {{-- PDF Librarys --}}
    <script src="{{ asset("assets/js/plugins/pdf/pdf.19.js") }}"></script>
    <script src="{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}"></script>
    {{-- Date range picker --}}
    {{-- <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script> --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" /> --}}
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('./assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link href="{{ asset('assets/css/nucleo-svg.css" rel="stylesheet') }}" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    {{-- <link id="pagestyle" data="bule" href="{{ asset('assets/css/argon-dashboard.2.0.0.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/css/validity.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/sidebar-nav.css') }}" rel="stylesheet" />
    <!-- toastr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @if(Route::currentRouteName() == 'filemanager')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- file manager --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <style>
        .fm .fm-body{
            height: 500px !important;
            background-color: #e2e2e2;
            padding: 5px;
            border: none;
            border-radius: 8px;
        }
    </style>
    @endif
    
     <style>
        @media screen and (max-width: 360px){
            html{
                min-width:360px !important;   
            }
            .card-footer{
                min-width:100% !important;   
            }
        }
        /* HTML: <div class="loader"></div> */
        .alert{
            z-index: 99764 !important;
        }
        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 999999;
            width: 120px;
            height: 120px;
            margin: -76px 0 0 -76px;
            border: 16px solid #fd1414;
            border-radius: 50%;
            border-top: 16px solid #131212;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
        .loader {
        width: 50px;
        aspect-ratio: 1;
        border-radius: 50%;
        border: 8px solid lightblue;
        border-right-color: rgb(255, 0, 0);
        animation: l2 1s infinite linear;
        }

        @keyframes l2 {to{transform: rotate(1turn)}}
        .input-sm {
            height: 30px !importain;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
 
        .btn:disabled{
            background: lightgray;
        }
        .badge.badge-xs{
            padding: 0.1em 0.3em;
        }
    </style>


    {{-- <style>
        /* Costum dropzone */
        .dz-preview{
            width: 100%;
            height: auto;
        }
        .dz-preview .dz-file-preview .dz-processing .dz-complete{
            margin-top:16px;
            nargin-bottom:0px !important;
        }
        .dropzone .dz-preview {
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 0px 0px 1px 0px !important;
            min-height: auto !important;
        }
        .dz-size{
            float: left;
            /* position: inherit !important; */
        }
        .dz-size, .dz-filename, .dz-progress{
            float: left;
        }
        .dropzone .dz-preview .dz-progress {
            /* opacity: 1; */
            z-index: 1000;
            pointer-events: none;
            position: absolute;
            height: 10px !important;
            left: 50%;
            top: auto !important;
            bottom: 1px !important;
            margin-bottom: 0px !important;
            width: 80px;
            margin-left: 0px !important;
            background: rgba(255,255,255,.9);
            -webkit-transform: scale(1);
            border-radius: 8px;
            overflow: hidden;
        }
        .dz-progress{
            /* opacity: 1 !important; */
            width: 100% !important;
            left: 0% !important;
        }
        .dz-details{
            margin-bottom: 0px !important;
        }
        .dropzone .dz-preview .dz-details {
            z-index: 20;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            font-size: 13px;
            min-width: 100%;
            max-width: 100%;
            padding: 1em 1em !important;
            text-align: center;
            color: rgba(0,0,0,.9);
            line-height: 150%;
        }
        .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
            ointer-events: none;
            /* opacity: 1; */
            z-index: 9999;
            display: block;
            position: absolute;
            top: 38% !important;
            right: 1% !important;
            margin-left: -27px;
            margin-top: -27px;
            margin-bottom: 0px !important;
        }
        .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
            /* background-color: rgba(255,255,255,.4); */
            padding: 0 0.4em;
            border-radius: 3px;
            margin-bottom: 0px !important;
        }
        .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
            background-color: transparent !important;
            padding: 0 0.4em;
            border-radius: 3px;
        }
        .dz-image{
            border-radius: 0px !important;
            background: #e7e7e7 !important;
            width: 100% !important;
            height: 50px !important;
            margin-bottom: 0px !important;
        }
        .dropzone .dz-preview .dz-image {
            border-radius: 20px;
            overflow: hidden;
            width: 120px;
            /* height: 73px !important; */
            position: relative;
            display: block;
            z-index: 10;
        }
        .dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
            width: 26px !important;
        }
        .dropzone .dz-preview .dz-error-message {
            pointer-events: none;
            z-index: 1000;
            position: sticky !important;
            /* display: none; */
            opacity: 1;
            /* -webkit-transition: opacity 0.3s ease; */
            -moz-transition: opacity 0.3s ease;
            -ms-transition: opacity 0.3s ease;
            -o-transition: opacity 0.3s ease;
            transition: opacity 0.3s ease;
            border-radius: 0px !important;
            font-size: 13px;
            top: auto !important;
            left: auto !important;
            width: auto !important;
            background: #be2626;
            background: linear-gradient(to bottom, #be2626, #a92222);
            padding: 0.5em 1.2em;
            color: #fff;
            margin-bottom: 1px !important;
        }
    </style> --}}
    

    <script>
        var myVar;
        const pageEnd = performance.mark('pageEnd');
        const loadTime = pageEnd.startTime / 1000;
         function loader() {
             myVar = setTimeout(showingPage, loadTime);
             console.log(loadTime);
        }
        function showingPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("main-page").style.display = "block";
            document.querySelector('body').style.background= '#f8f9fa !important';
        }
    </script>
    

</head>
<body onload="loader()" class="{{ $class ?? '' }}" style="margin:0; background-color: '#6c757d !important">
   
    {{-- @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible text-white" style="position: fixed;
    width: 100%;">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif --}}

    <div id="loader"></div>
    <div id="main-page" style="display:none;">
        @guest
            @yield('content')
        @endguest

        @auth
            @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
                @yield('content')
            @else
                @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
                    <div class="min-height-300 bg-primary position-absolute w-100"></div>
                @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                    <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                        <span class="mask bg-primary opacity-6"></span>
                    </div>
                @endif
                @role('Superadmin, web')
                    @include('layouts.navbars.auth.sidenavsuper') 
                @else
                    @include('layouts.navbars.auth.sidenav')
                @endrole
                    <main class="main-content border-radius-lg">
                        <div class="container-fluid py-4">
                        @yield('content')
                        </div>
                        @include('layouts.footers.auth.footer')
                    </main>
                {{-- @include('components.fixed-plugin') --}}
            @endif
        @endauth
    </div>
       
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" style="z-index: 999999;" id="modalLogout" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId"><i class="fas fa-power-off text-lg opacity-10" aria-hidden="true"></i></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure, you want to log out?
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</a>
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset("assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script id="js-main">
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                // damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        
        // toastr option
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000", //3000
            "hideDuration": "1000", //1000
            "timeOut": "5000", //5000
            "extendedTimeOut": "1000", //1000
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": true
        }
        
        setTimeout(function(){
            $('.alert').fadeOut();
        },5000);
        //message
        @if($message = Session::get('success'))
        toastr["success"]('{{ $message }}','success'); 
        @elseif($message = Session::get('error'))
        toastr["error"]('{{ $message }}','error'); 
        @endif
        @if (env('APP_ENV')!='production')
    // toastr["success"]("Toastr Test", "Toastr Test");
        // toastr["info"]("error", "Toastr Test");
        // toastr["error"]("error", "Toastr Test");
        // toastr["warning"]('Clear itself?<br /><br /><button type="button" class="btn clear">Yes</button>');
        @endif
        
    </script>

    <!-- Github buttons -->
    {{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
    <script async defer src="{{ asset('assets/js/plugins/buttons.js') }}"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    @stack('js')
    <script>
        //Optional: Place to the bottom of scripts 
        if (document.getElementById('modalId') !== null) {
            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
        }   
    </script>
</body>

</html>

