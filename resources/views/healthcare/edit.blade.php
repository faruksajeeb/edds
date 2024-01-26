@push('styles')
<style>

</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Healthcare
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Healthcare</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('healthcares') }}">healthcares</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('healthcares.update', Crypt::encryptString($editInfo->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Center Type
                                <span class='text-danger'>*<span></label>
                            <select name="center_type" id="center_type" class="form-select" required>
                                <option value="">--select center type--</option>
                               
                                <option value="human" {{ "human" == old('center_type', $editInfo->type) ? 'selected' : '' }}>Human</option>
                                <option value="animal" {{ "animal" == old('center_type', $editInfo->type) ? 'selected' : '' }}>Animal</option>
                               
                            </select>
                            @if ($errors->has('center_type'))
                            @error('center_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select category.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('hospital_name_english')) has-error @endif fw-bold">Healthcare Name in
                                English <span class="text-danger">*</span></label><br />
                            <input type="text" name='hospital_name_english' id='hospital_name_english' class="form-control @error('hospital_name_english') is-invalid @enderror" placeholder="Enter healthcare name in english" value="{{ old('hospital_name_english',$editInfo->hospital_name_english) }}" required>
                            @if ($errors->has('hospital_name_english'))
                            @error('hospital_name_english')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a healthcare name in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('hospital_name_bangla')) has-error @endif fw-bold">Healthcare Name in
                                Bangla <span class="text-danger">*</span> </label><br />
                            <input type="text" name='hospital_name_bangla' id='hospital_name_bangla' class="form-control @error('hospital_name_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে স্বাস্থ্যসেবা কেন্দ্রের নাম বাংলায় লিখুন" value="{{ old('hospital_name_bangla',$editInfo->hospital_name_bangla) }}" required>
                            @if ($errors->has('hospital_name_bangla'))
                            @error('hospital_name_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a healthcare name in Bangla.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="latitude" class="@if ($errors->has('latitude')) has-error @endif fw-bold">
                                        Latitude <span class="text-danger">*</span></label><br />
                                    <input type="text" pattern="[0-9.-]" name='latitude' id='latitude' class="form-control @error('latitude') is-invalid @enderror" placeholder="Enter Latitude" value="{{ old('latitude',$editInfo->latitude) }}" required>
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
                                    <input type="text" pattern="[0-9.-]" name='longitude' id='longitude' class="form-control @error('longitude') is-invalid @enderror" placeholder="Enter longitude" value="{{ old('longitude',$editInfo->longitude) }}" required>
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
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('address')) has-error @endif fw-bold">healthcare
                                Address</label><br />
                            <textarea name='address' id='address' class="form-control @error('address') is-invalid @enderror" placeholder="Enter healthcare address" rows="3">{{ old('address',$editInfo->address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit"><i class="fa fa-save"></i> Save Data</button>
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