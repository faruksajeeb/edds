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
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Create Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('markets') }}">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('markets.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Market Area <span class="text-danger">*</span></label>
                            <select name="area_id" id="area_id" class="form-select select2" required>
                                <option value="">--select area--</option>
                                @foreach ($areas as $val)
                                <option value="{{ $val->id }}" {{ $val->id == old('area_id') ? 'selected' : '' }}>
                                    {{ $val->value }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('area_id'))
                            @error('area_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select area.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('value')) has-error @endif fw-bold">Market Name in
                                English <span class="text-danger">*</span></label><br />
                            <input type="text" name='value' id='value' class="form-control @error('value') is-invalid @enderror" placeholder="Enter market name in english" value="{{ old('value') }}" required>
                            @if ($errors->has('value'))
                            @error('value')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a market name in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Market Name in
                                Bangla <span class="text-danger">*</span></label><br />
                            <input type="text" name='value_bangla' id='value_bangla' class="form-control @error('value_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে বাংলায় বাজারের নাম লিখুন" value="{{ old('value_bangla') }}" required>
                            @if ($errors->has('value_bangla'))
                            @error('value_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a market name in bangla.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="latitude" class="@if ($errors->has('latitude')) has-error @endif fw-bold">
                                        Latitude <span class="text-danger">*</span></label><br />
                                    <input type="number" pattern="[0-9.-]" name='latitude' id='latitude' class="form-control @error('latitude') is-invalid @enderror" placeholder="Enter Latitude" value="{{ old('latitude') }}" min="-90" max="90" required>
                                    @if ($errors->has('latitude'))
                                    @error('latitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @else
                                    <div class="invalid-feedback">
                                        Please enter a valid latitude.
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="@if ($errors->has('longitude')) has-error @endif fw-bold">
                                        Longitude <span class="text-danger">*</span></label><br />
                                    <input type="number" pattern="[0-9.-]" name='longitude' id='longitude' class="form-control @error('longitude') is-invalid @enderror" placeholder="Enter longitude" value="{{ old('longitude') }}" min="-180" max="180" required>
                                    @if ($errors->has('longitude'))
                                    @error('longitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @else
                                    <div class="invalid-feedback">
                                        Please enter a valid longitude.
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="sms_code" class="@if ($errors->has('sms_code')) has-error @endif fw-bold">
                                        SMS Code <span class="text-danger"></span></label><br />
                                    <input type="text" name='sms_code' id='sms_code' class="form-control @error('sms') is-invalid @enderror" placeholder="Enter Sms Code" value="{{ old('sms_code') }}">
                                    @if ($errors->has('sms_code'))
                                    @error('sms_code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @else
                                    <div class="invalid-feedback">
                                        Please enter a valid sms code.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('market_address')) has-error @endif fw-bold">Market
                                Address</label><br />
                            <textarea name='market_address' id='market_address' class="form-control @error('market_address') is-invalid @enderror" placeholder="Enter market address" rows="3">{{ old('market_address') }}</textarea>
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function() {

        });
    </script>
    @endpush
</x-app-layout>