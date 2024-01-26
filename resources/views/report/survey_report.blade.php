<x-app-layout>
    <x-slot name="title">
        Survey Report
    </x-slot>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form id="reportForm" action="{{route('survey-report')}}" method="POST" class="needs-validation" target="_blank" novalidate>
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Survey Report</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mb-2">
                                    <label class="col-md-4">Area</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="area_id" name="area_id">
                                            <option value="">--Select Area--</option>
                                            @foreach($areas as $area)
                                            <option value="{{$area->id}}" {{ (session('area_id')==$area->id)?'selected':''}}>{{$area->value}} - {{$area->value_bangla}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-4">Market</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" id="market_id" name="market_id">
                                            <option value="">--Select Area First--</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-4">Distance Matrix (Km) <i class="fa-solid fa-circle-radiation inline-block"></i></label>
                                    <div class="col-md-8">
                                        <input type="number" name="distance" id="distance" value="{{session('distance')}}" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="ate from" class="col-md-4 col-form-label">Response Date From <span class="text-danger fw-bold"> *</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="datepicker form-control" value="{{ (session('date_from'))?session('date_from'):date('Y-m-d', strtotime('-7 days')) }}" name="date_from" required />
                                        @if ($errors->has('date_from'))
                                        @error('date_from')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <div class="invalid-feedback">
                                            Please select date from.
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="date to" class="col-sm-4 col-form-label">Response Date To <span class="text-danger fw-bold"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="datepicker form-control" value="{{ (session('date_to'))?session('date_to'):date('Y-m-d') }}" name="date_to" required />
                                        @if ($errors->has('date_to'))
                                        @error('date_to')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        @else
                                        <div class="invalid-feedback">
                                            Please select date to.
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="date to" class="col-sm-4 col-form-label">Status <span class="text-danger fw-bold"> </span></label>
                                    <div class="col-sm-8">
                                        <select name="status" class="form-select" id="status">
                                            <option value="">All</option>
                                            <option value="2" {{ session('status') == '2' ? 'selected' : '' }}>Verified
                                            </option>
                                            <option value="1" {{ session('status') == '1' ? 'selected' : '' }}>Pending
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="date to" class="col-sm-4 col-form-label">Heading <span class="text-danger fw-bold"> </span></label>
                                    <div class="col-sm-8">
                                        <select name="heading" class="form-select" id="heading">
                                            <option value="">All</option>
                                            @foreach($headings as $q)
                                            <option value="{{$q->answare}}" {{ session('heading') == $q->answare ? 'selected' : '' }}>{{$q->answare}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="date to" class="col-sm-4 col-form-label">Items <span class="text-danger fw-bold"> </span></label>
                                    <div class="col-sm-8">
                                        <select name="item" class="form-select" id="item">
                                            <option value="">--Select Heading First--</option>
                                            <!-- @foreach($answers as $q)
                                            <option value="{{$q->answare}}" {{ session('item') == $q->answare ? 'selected' : '' }}>{{$q->answare}}</option>
                                            @endforeach -->
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-lg btn-info " type="submit" name='submit_btn' value="view"><i class="fas fa-search"></i> View Report</button>
                        <button class="btn btn-lg btn-danger " type="submit" name='submit_btn' value="pdf"><i class="fas fa-file"></i> Export/ Download <i class="fas fa-download"></i> </button>
                        <!-- <button class="btn btn-md btn-success" type="submit" name='submit_btn' value="export"><i class="fas fa-file-excel"></i> Export</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            @if (isset($report_format) && $report_format=='view')
            @php
            //$data = (Object)$data;
            @endphp

            <!-- @include('report.survey_report_export') -->


            @endif
        </div>
    </div>
    @push('scripts')
    <script>
        document.getElementById('reportForm').addEventListener('submit', function() {
            // You can perform any additional actions here before going back, if needed

            // Go back to the previous page
            // window.history.back();
        });
        $(document).ready(function() {
            var area_id = $('#area_id').val();
            if (area_id) {
                getMarket(area_id, 'onload');

            }
            // alert();

            $('#area_id').change(function() {
                var area_id = $(this).val();
                if (area_id) {
                    getMarket(area_id, 'onchange');
                }
            });


            var heading = $('#heading').val();
            if (heading) {
                getItems(heading, 'onload');

            }
            // alert();

            $('#heading').change(function() {
               
                var heading = $('#heading').val();
                // alert(heading);
                if (heading) {
                    getItems(heading, 'onchange');
                }
            });
        });

        const getDistrict = (val) => {
            if (val) {
                $.ajax({
                    url: "{{ url('api/fetch-districts') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        division_id: val
                    },
                    success: (response) => {
                        $('#district_name').html('<option value="">-- Select District --</option>');
                        $.each(response.districts, (key, value) => {
                            $("#district_name").append('<option value="' + value
                                .id + '">' + value.district_name + '(' + value.district_name_bangla + ')</option>');
                        });
                    },
                    error: (xhr, status, error) => {

                    }
                });
            }
        }

        const getArea = (val) => {
            if (val) {
                // by jquery
                $.ajax({
                    url: "{{ url('api/fetch-areas') }}",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        upazilla: val
                    },
                    success: (response) => {
                        $('#area_id').html('<option value="">-- Select Area --</option>');
                        $.each(response.areas, (key, value) => {
                            $("#area_id").append('<option value="' + value
                                .id + '">' + value.value + '</option>');
                        });
                    },
                    error: (xhr, status, error) => {

                    }
                });
            }
        }
        const getMarket = async (val, type) => {
            if (val) {
                // by raw/vanilla javascript api
                await fetch("{{ url('api/fetch-markets') }}/" + val)
                    .then(response => response.json())
                    .then(data => {
                        let marketSelect = document.querySelector('#market_id');
                        marketSelect.innerHTML = '<option value="">-- Select Market --</option>'; // Clear existing options
                        data.markets.forEach((market) => {
                            var option = document.createElement('option');
                            option.value = market.id;
                            option.text = market.value;
                            marketSelect.appendChild(option);
                        });
                        if (type == 'onload') {
                            $('#market_id').val(<?php echo session('market_id') ?>);
                        }




                    });
            }
        }
        const getItems = async (val, type) => {
            if (val) {
                // by raw/vanilla javascript api
                await fetch("{{ url('api/fetch-items') }}/" + val)
                    .then(response => response.json())
                    .then(data => {
                        let itemSelect = document.querySelector('#item');
                        itemSelect.innerHTML = '<option value="">-- Select Item --</option>'; // Clear existing options
                        data.items.forEach((item) => {
                            var option = document.createElement('option');
                            option.value = item.answare;
                            option.text = item.answare;
                            itemSelect.appendChild(option);
                        });
                        if (type == 'onload') {
                            $('#item').val(<?php echo session('item') ?>);
                        }
                    });
            }
        }
    </script>
    @endpush
</x-app-layout>