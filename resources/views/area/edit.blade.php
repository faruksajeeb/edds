@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Area
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Area</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('areas') }}">Areas</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('areas.update', Crypt::encryptString($areaInfo->id)) }}"
                        method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value')) has-error @endif fw-bold">Value  <span class="text-danger">*</span></label><br />
                            <textarea name='value' id='value' class="form-control @error('value') is-invalid @enderror"
                                placeholder="Enter  value" rows="3" required>{{ old('value',$areaInfo->value) }}</textarea>
                            @if ($errors->has('value'))
                                @error('value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please enter a value.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Value
                                Bangla</label><br />
                            <textarea name='value_bangla' id='value_bangla' class="form-control @error('value_bangla') is-invalid @enderror"
                                placeholder="Enter  value in bangla" rows="3">{{ old('value_bangla',$areaInfo->value_bangla) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="latitude" class="@if ($errors->has('latitude')) has-error @endif fw-bold">
                                Latitude  <span class="text-danger">*</span></label><br />
                            <input type="text" name='latitude' id='latitude'
                                class="form-control @error('latitude') is-invalid @enderror"
                                placeholder="Enter Latitude" value="{{ old('latitude',$areaInfo->latitude) }}" required>
                            @if ($errors->has('latitude'))
                                @error('latitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please enter a latitude.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="longitude" class="@if ($errors->has('longitude')) has-error @endif fw-bold">
                                Longitude <span class="text-danger">*</span></label><br />
                            <input type="text" name='longitude' id='longitude'
                                class="form-control @error('longitude') is-invalid @enderror"
                                placeholder="Enter longitude" value="{{ old('longitude',$areaInfo->longitude) }}" required>
                            @if ($errors->has('longitude'))
                                @error('longitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please enter a longitude.
                                </div>
                            @endif
                        </div>
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit">Save Changes</button>
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
