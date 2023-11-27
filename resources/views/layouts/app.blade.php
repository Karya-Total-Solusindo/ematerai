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
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('./assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="{{ asset('assets/js/plugins/fontawesome_42d5adcbca.js') }}" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset("assets/js/plugins/pdf/pdf.js") }}" type="module"></script> --}}
        <!-- jQuery 3 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js" integrity="sha512-59swnhUs+9AinrKlTPqsoO5ukNPPFbPXFyaf41MAgiTG/fv3LBZwWQWiZNYeksneLhiUo4xjh/leTZ53sZzQ4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- toastr js -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        {{-- PDF Librarys --}}
        <script src="{{ asset("assets/js/plugins/pdf/pdf.19.js") }}"></script>
        <script src="{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}"></script>


    
    <link href="{{ asset('assets/css/nucleo-svg.css" rel="stylesheet') }}" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    {{-- <link id="pagestyle" data="bule" href="{{ asset('assets/css/argon-dashboard.2.0.0.min.css') }}" rel="stylesheet" /> --}}
    <link id="pagestyle" href="{{ asset('assets/css/validity.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/sidebar-nav.css') }}" rel="stylesheet" />
    <!-- toastr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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
        .form-control-sm + span{
            content: "✓";
            top:-29px;
        }

        .btn:disabled{
            background: lightgray;
        }
    </style>
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
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible text-white" style="position: fixed;
    width: 100%;">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
 
    <x-alert id="my-alert" role="alert" type="success">
        Uh oh!
    </x-alert>
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
            @role('Superadmin', 'web')
                @include('layouts.navbars.auth.sidenavsuper') 
            @else
                @include('layouts.navbars.auth.sidenav')
            @endrole
                <main class="main-content border-radius-lg">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </main>
            @include('components.fixed-plugin')
        @endif
    @endauth
    </div>               
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset("assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
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
</body>

</html>

