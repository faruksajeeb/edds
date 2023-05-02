<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>EDDS</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets/imgs/theme/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/font-awesome.min.css') }}">
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link href="{{ asset('frontend-assets/css/tailwind.min.css') }}" 
          rel="stylesheet"> 
    <style>
        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            z-index: 3;
            color: #23527c;
            background-color: purple;
            border-color: #ddd;
        }
    </style>
      @stack('styles')
    @livewireStyles
</head>


<body>
    {{-- @include('livewire.frontend.header') --}}

    <main class="main">
        {{-- {{ $slot }} --}}
        @yield('content')
    </main>

    {{-- @include('livewire.frontend.footer') --}}
    <!-- Vendor JS-->
    <script src="{{ asset('frontend-assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend-assets/js/main.js?v=3.3') }}"></script>
    <script src="{{ asset('frontend-assets/js/shop.js?v=3.3') }}"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        Livewire.on('added', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: ''+message+ '',
                showConfirmButton: false,
                timer: 2500
            })
        })
        Livewire.on('error', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'SORRY',
                text: ''+message+ '',
                showConfirmButton: true,
                timer: 5000
            })
        })
    </script>
</body>


</html>
