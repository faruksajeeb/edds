<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/uploads/' . $theme_settings->website_logo) }}">
    <title>{{ config('app.name', 'Laravel') }} | {{ $title }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('plugins/jquery-ui/jquery-ui.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css" rel="stylesheet') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />


    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/decoupled-document/ckeditor.js"></script> --}}

    <link rel="stylesheet" href="{{ asset('plugins/datetimepicker/jquery.datetimepicker.css') }}" />
    <!-- year Picker -->
    <link rel="stylesheet" href="{{ asset('plugins/yearpicker/yearpicker.css') }}" />
    <!-- date range picker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Month Picker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/monthpicker/MonthPicker.min.css') }}" />
    <style>
        .themed-grid-col {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(86, 61, 124, .15);
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .themed-container {
            padding: .75rem;
            margin-bottom: 1.5rem;
            background-color: rgba(0, 123, 255, .15);
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .pagination>li>a:focus,
        .pagination>li>a:hover,
        .pagination>li>span:focus,
        .pagination>li>span:hover {
            z-index: 3;
            color: #23527c;
            background-color: purple;
            border-color: #ddd;
        }

        .disabledAnchor {
            pointer-events: none !important;
            cursor: default;
            color: #CCC;
        }

        .reset {
            all: revert;
        }
    </style>



    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.sidebar')
        <section id="main" class="main">
            @include('layouts.topbar')
            <div class="main-content p-2">
                @include('layouts.flash-message')
                <main>
                    {{ $slot }}
                </main>
            </div>
        </section>
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

        <!-- Page Content -->
        {{-- <main>
            {{ $slot }}
        </main> --}}
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script> --}}

    <script src="{{ asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <!-- Yearpicker -->
    <script src="{{ asset('plugins/yearpicker/yearpicker.js') }}"></script>
    <!-- daterange picker -->
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Month Picker -->
    <script type="text/javascript" src="{{ asset('plugins/monthpicker/MonthPicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {

        });
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            $('.select2').select2({
                width: '100%',
                placeholder: function() {
                    $(this).data('placeholder');
                }
            });
            $('.btn-submit').prop('disabled', false);
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
                            $('.btn-submit').prop('disabled', true);
                            $('.btn-submit').html('Saving...');
                            $('.btn-import').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing...');
                        }
                        form.classList.add('was-validated')
                    }, false)

                })

        })();


        $(".yearpicker").yearpicker();
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $(".datetimepicker").datetimepicker({
            format: 'Y-m-d H:i:00',
            "step": 30 //Will Change Minute Interval as 00, 05, 10 ... 55
        });
        $(".monthpicker").MonthPicker({
            ShowIcon: false
            // Button: '<button>...</button>'
        });

        $(document).ready(function() {
            $('.select2').select2();
        });

        function toggleMenu() {
            let toggle = document.querySelector(".toggle");
            let navigation = document.querySelector(".navigation");
            let main = document.querySelector(".main");
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        }
        // $(document).on('click', ".delete", function(e) {
        //     e.preventDefault();

        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         return true;
        //     })
        // });

        $(document).on('click', ".active_inactive_btn", function() {
            // var status;
            // if ($(this).is(':checked')) {
            //     alert('checked');
            //     status = 7;                    
            // }else{
            //     status = -7;                   
            // }  

            var id = $(this).val();
            var status = $(this).attr('status');
            var field_id = $(this).attr('id');
            $.ajax({
                type: "GET",
                url: "{{ route('active.inactive') }}",
                dataType: "json",
                data: {
                    id: id,
                    status: $(this).attr('status'),
                    table: $(this).attr('table')
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#" + field_id).attr('status', response.changed_value);
                        if (response.changed_value == -7) {
                            $('#edit_btn_' + field_id).prop('disabled', true);
                        } else if (response.changed_value == 7) {
                            $('#edit_btn_' + field_id).prop('disabled', false);
                        }
                    } else if (response.status == 'not_success') {
                        var $checkbox = $("#" + field_id);
                        ($checkbox.prop("checked") == true) ? $checkbox.prop("checked", false):
                            $checkbox.prop("checked", true);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                        return false;
                    }
                },
                error: function(xhr, status, error) {
                    // handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                    });
                    return false;
                }
            })

        });

        //....................................Sortable...................................
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.9,
            handle: 'span',
            update: function(event, ui) {
                var list_sortable = $(this).sortable('toArray').toString();
                var tablename = $(this).attr('tablename');
                // change order in the database using Ajax
                //    alert(tablename);
                processing('Reordering...');
                $.ajax({

                    url: "{{ route('change-order') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        list_order: list_sortable,
                        table_name: tablename
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 5000
                            });
                        } else if (response.status == 'not_success') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                            return false;
                        }
                    },
                    error: function(xhr, status, error) {
                        // handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error,
                        });
                        return false;
                    }
                });
            }
        }); // finished sortable

        let confirmDelete = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You can be able to revert this!'",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.btn-delete-' + id).addClass('disabledAnchor');
                    $('.btn-delete-' + id).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...'
                    );
                    document.getElementById('delete-form-' + id).submit();
                    processing('Deleting...');
                }

            })
        }
        let forceDelete = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!'",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.btn-force-delete-' + id).addClass('disabledAnchor');
                    $('.btn-force-delete-' + id).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Force Deleting...'
                    );
                    document.getElementById('force-delete-form-' + id).submit();
                    processing('Force Deleting...');
                }

            })
        }
        let restoreConfirmation = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore this!'",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.btn-restore-' + id).addClass('disabledAnchor');
                    $('.btn-restore-' + id).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Restoring...'
                    );
                    document.getElementById('restore-form-' + id).submit();
                    processing('Restoring...');
                }

            })
        }
        let restoreAllConfirmation = () => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore all archived data!'",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore all!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.btn-restore-all').addClass('disabledAnchor');
                    $('.btn-restore-all').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Restoring All...'
                    );
                    document.getElementById('restore-all-form').submit();
                    processing('Restoring All...');
                }

            })
        }

        $(document).on('click', ".export_btn", function() {
            // $('.export_btn').html(
            //             '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Exporting...'
            //         );
        });
        $(document).on('click', ".filter_btn", function() {
            // processing('Exporting...');
            $('.filter_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Filtering...'
            );
        });
        $(document).on('click', ".refresh_btn", function() {
            // processing('Exporting...');
            $('.refresh_btn').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Refreshing...'
            );
        });

        let processing = (val) => {
            Swal.fire({
                title: val,
                // html: 'I will close in <b></b> milliseconds.',
                html: '',
                //timer: 10000,
                allowOutsideClick: false,
                timerProgressBar: false,
                didOpen: () => {
                    Swal.showLoading()
                    /*const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                    	b.textContent = Swal.getTimerLeft()
                    }, 100)*/
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        }
    </script>

    @stack('scripts')

    @livewireScripts
    <script>
        Livewire.on('success', message => {
            $(".modal").modal('hide');
            Swal.fire(
                'Success!',
                'Data ' + message + ' successfully!',
                'success'
            )
        })
        Livewire.on('error', message => {
            Swal.fire(
                'Error!',
                message,
                'error'
            )
        })
    </script>
</body>

</html>
