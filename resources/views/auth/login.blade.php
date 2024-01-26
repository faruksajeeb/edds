<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <title>{{ $company_settings->company_name }} | Login</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome/css/all.min.css') }}">
    <style>
        .disabledAnchor {
            pointer-events: none !important;
            cursor: default;
            color: #CCC;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4" style="margin-top:200px">
                <div class="text-center">
                    <h2 class="text-center">{{ $company_settings->company_name }} - LOGIN</h2>
                </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="">Email *:</label>
                        <input type="email" class="form-control " name="email" value="{{ old('email','admin@admin.com') }}" required
                            autofocus />
                        @if ($errors->has('email'))
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @else
                            <div class="invalid-feedback">
                                Please enter a valid email.
                            </div>
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <label for="">Password *:</label>
                        <input type="password" class="form-control " value="12345678" type="password" name="password" required
                            autocomplete="current-password" />
                        @if ($errors->has('password'))
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @else
                            <div class="invalid-feedback">
                                Please enter password.
                            </div>
                        @endif
                    </div>
                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-login mx-1 display-block" id='btn-login'>Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        // alert(77);
                        $('#btn-login').addClass('disabledAnchor');
                        $('#btn-login').prop('disabled', true);
                        $('#btn-login').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging In...'
                        );
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })();
</script>

@stack('scripts')



</body>

</html>
