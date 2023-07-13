@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Market
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Import Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('markets') }}">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Import</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="import-form" action="{{ route('markets.import') }}" method="POST"
                        class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="form-group mb-3">
                            <label for="import_file" class="@if ($errors->has('import_file')) has-error @endif fw-bold">
                                Import File <span class="text-danger">*</span></label><br />
                            <input type="file" name='import_file' id='import_file'
                                class="form-control @error('import_file') is-invalid @enderror"
                                placeholder="Enter import_file" value="{{ old('import_file') }}" required>
                            @if ($errors->has('import_file'))
                                @error('import_file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select a valid file.
                                </div>
                                <div class="text-info">
                                    Please must be select a file of type: xls, xlsx, csv.
                                </div>
                            @endif
                        </div>

                        Upload File Format Sample:
                        <table style="font-size:10px" class="table table-sm table-bordered my-0">
                            <tr>
                                <td class=""></td>
                                <td>A</td>
                                <td>B</td>
                                <td>C</td>
                                <td>D</td>
                                <td>E</td>
                                <td>F</td>
                            </tr>
                            <tr style="background-color: #C5DFF8; color:black;font-weight:bold">
                                <td class="" style="background-color: #FFF;font-weight:normal">1</td>
                                <td class="text-danger">Area</td>
                                <td class="text-danger">Market_Name_Eng</td>
                                <td>Market_Name_Ban</td>
                                <td>Market_Address</td>
                                <td class="text-danger">Latitude</td>
                                <td class="text-danger">Longitude</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>DNCC</td>
                                <td>Panir Tanki Bazar</td>
                                <td>পানির ট্যাংকি বাজার</td>
                                <td>11C, Avenue-5, Mirpur-11</td>
                                <td>23.81464</td>
                                <td>90.37478</td>
                            </tr>
                        </table>
                        [* Red text color fields are required.]
                        <a class="float-end my-0 fst-italic"
                            href="{{ asset('uploads/upload_file_format/upload_markets_format.xlsx') }}">Download The
                            Format</a>
                        <br />
                        <br />

                        <div class="form-group">
                            <button type="submit" name="submit_btn" class="btn btn-lg btn-success btn-import"
                                onclick="startClock()">Import</button>
                            <p id="clock" class="float-end d-none">00:00:00</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function startClock() {
                var clockElement = document.getElementById('clock');
                var file = $('#import_file').val();
                if (file) {
                    $('#clock').show();
                    var startTime = new Date().getTime();
                    var intervalId = setInterval(function() {
                        var currentTime = new Date().getTime();
                        var elapsedTime = currentTime - startTime;

                        var hours = Math.floor(elapsedTime / (1000 * 60 * 60));
                        var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                        var timeString = formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds);

                        clockElement.textContent = timeString;
                    }, 1000);
                }

            }

            function formatTime(time) {
                return time < 10 ? '0' + time : time;
            }
        </script>
    @endpush
</x-app-layout>
