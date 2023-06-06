<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $theme_settings->website_name }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/uploads/' . $theme_settings->website_logo) }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/font-awesome.min.css') }}">
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link href="{{ asset('frontend-assets/css/tailwind.min.css') }}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        @font-face {
            font-family: myDefaultFont;
            src: url({{ asset('fonts/MaterialIcons-Regular.ttf') }});
        }
        @font-face {
            font-family: solaimanLipiBanglaFont;
            src: url({{ asset('frontend-assets/fonts/SolaimanLipi/SolaimanLipi.ttf') }});
        }
        *{
            /* font-family: myDefaultFont; */
            font-family:'Times New Roman', Times, serif
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
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @livewireScripts
    @stack('scripts')
    <script>
        Livewire.on('added', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '' + message + '',
                showConfirmButton: false,
                timer: 2500
            })
        })
        Livewire.on('error', message => {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'SORRY',
                text: '' + message + '',
                showConfirmButton: true,
                timer: 5000
            })
        })
    </script>
</body>


</html>
