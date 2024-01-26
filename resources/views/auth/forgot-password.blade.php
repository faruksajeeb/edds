<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <title>{{ $company_settings->company_name }}  | Forgot Password</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome/css/all.min.css') }}">
    <style>

    </style>
    @stack('styles')
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4" style="margin-top:200px">
                <div class="text-center">
                    <h2 class="text-center">{{ $company_settings->company_name }} - Forgot Password</h2>
                </div>
                <hr>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 alert alert-success text-success" :status="session('status')" />
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif


                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->

                <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="email" name="email"
                            placeholder="Enter valid user email" :value="old('email')" required autofocus />
                        {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                        @if ($errors->has('email'))
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @else
                            <div class="invalid-feedback">
                                Please enter a registered email.
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="btn btn-primary btn-submit" type="submit" name="btn-submit">
                           {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- Session Status -->
<!--
<x-auth-session-status class="mb-4" :status="session('status')" />
-->

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
                        $('.btn-submit').addClass('disabledAnchor');
                        $('.btn-submit').prop('disabled', true);
                        $('.btn-submit').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Link Sending...'
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
