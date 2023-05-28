@push('styles')
    <style>
        .nav-link {
            font-size: 20px;
            font-weight: bold;
        }

        .themed-grid-col {
            min-height: 250px;
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #e88923;
            border: 5px solid rgba(255, 255, 255, 1);

            color: #FFFFFF;
        }

        .themed-container {
            padding: .75rem;
            margin-bottom: 1.5rem;
            background-color: rgba(0, 123, 255, .15);
            border: 5px solid rgba(255, 255, 255, 1);
        }

        .primary_text_color {
            color: #e88923;
        }

        .primary_bg_color {
            background-color: #e88923 !important;
        }

        .big_number {
            font-size: 50px;
            font-weight: bold;
        }
    </style>
@endpush
<div class="container-fluid mx-0 px-0">
    <div class="container-fluid header-section py-3">
        <div class="container">
            <!-- navigation -->
            <header class="navigation">
                <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
                    <div class="container">
                        <a class="navbar-brand" href="{{ route('/') }}">
                            <img loading="prelaod" decoding="async" class="img-fluid" width="160"
                                src="{{ asset('/uploads/' . $theme_settings->website_logo) }}" alt="icddr,b">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"> <span
                                class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                                <li class="nav-item"> <a class="nav-link" href="{{ route('/') }}">{{ __('menu.home') }}</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="{{ route('/') }}">{{ __('menu.about') }}</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="{{ route('/') }}">{{ __('menu.services') }}</a>
                                </li>
                                <li class="nav-item "> <a class="nav-link" href="{{ route('/') }}">{{ __('menu.contact') }}</a>
                                </li>
                                {{-- <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#"
                                        id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">Pages</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item " href="">DropDown 1</a>
                                        </li>
                                        <li><a class="dropdown-item " href="">DropDown 2</a>
                                        </li>
                                        <li><a class="dropdown-item " href="">DropDown 3</a>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">{{ __('menu.login') }}</a>
                            @if ((session()->get('locale') == 'bn'))
                                <button class="btn btn-danger text-white ms-2 changeLang" value="en">English</button>
                            @elseif(!session()->get('locale') || session()->get('locale') == 'en')
                                <button class="btn primary_bg_color text-white ms-2 changeLang" value="bn">বাংলা</button>
                            @endif

                        </div>
                    </div>
                </nav>
            </header>
            <!-- /navigation -->
        </div>
    </div>
    <div class="container-fluid slider-section h-100 mx-0 px-0 py-5 " style="background-color: #FFDEAD">

        <div class="container my-3">
            <div class="row align-items-md-stretch">
                @foreach ($categories as $category)
                    <div class="col-md-4 my-3">
                        <div class="h-100 p-3 text-dark bg-white rounded-3 text-center">
                            <div class="iconBox">
                                {{-- <i class="fa fa-eye"></i> --}}
                                <span class="big_number">{{ (session()->get('locale')=='bn')?$webspice->convertToBanglaNumber($category['response_data']):$category['response_data'] }}</span>
                                <p>{{ __('text.today') }}</p>
                            </div>
                            <h2 class="fw-bold my-5 primary_text_color">{{ (session()->get('locale')=='bn')?$category['category_name_bangla'] : $category['category_name'] }}</h2>


                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <div class="row row-cols-1 row-cols-md-3 gx-4 m-1">
                <div class="col themed-grid-col h-100 py-5 text-center align-middle">

                    <h1 class="text-center ">Poultry</h1>
                </div>
                <div class="col themed-grid-col h-100 py-5">
                    <h1 class="text-center">Wild Bird</h1>
                </div>
                <div class="col themed-grid-col h-100 py-5">
                    <h1 class="text-center">LBM Worker</h1>
                </div>                
            </div> --}}
        </div>

    </div>

    <div class="container-fluid mx-0 px-0 py-5">
        <div class="container my-5 table-responsive-sm">
            <table class="table  table-hover ">
                <thead>
                    <?php
                    $colSpan = count($categories);
                    ?>
                    <tr class="primary_bg_color">
                        <th colspan="{{ $colSpan + 1 }}"
                            class="text-center py-3 primary_bg_color text-white display-6">{{__('text.tabular_statistic_title')}}</th>
                    </tr>
                    <tr class="table-dark">
                        <th class="">{{__('text.location')}}</th>
                        @foreach ($categories as $category)
                            <th class="text-center">{{ (session()->get('locale')=='bn')?$category['category_name_bangla'] : $category['category_name'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisions as $division)
                        <tr class="table-warning">
                            <td class="">{{ (session()->get('locale')=='bn')?$webspice->convertToBanglaDivision($division['division_name']):$division['division_name'] }}</td>
                            @foreach ($categories as $key => $category)
                                <td class="text-center">{{ (session()->get('locale')=='bn')?$webspice->convertToBanglaNumber($division[$key]) : $division[$key] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-fluid py-3  primary_bg_color ">
        <div class="container text-center text-white">
            {{__('text.copyright')}}
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        var url = "{{ route('changeLang') }}";

        $(".changeLang").on('click',function() {
            $('.changeLang').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Language Changing...'
                    );
            var lang = $(this).attr('value');
            //alert(lang);
            window.location.href = url + "?lang=" + lang;
        });
    </script>
@endpush
