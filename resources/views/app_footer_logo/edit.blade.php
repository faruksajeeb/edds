@push('styles')
<style>
  #preview-image {
            max-width: 300px;
            max-height: 300px;
            margin-top: 20px;
        }
</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit App Footer Logo
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit App Footer Logo</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('app_footer_logos') }}">app footer logoss</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app_footer_logos.update', Crypt::encryptString($editInfo->id)) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('hospital_name_english')) has-error @endif fw-bold">App Footer Logo <span class="text-danger">*</span></label><br />

                            @php
                                // Extract the base64 encoded data from the string
                                $base64Data = substr($editInfo->logo_base64, strpos($editInfo->logo_base64, ',') + 1);

                                // Create a data URL for the image
                                $dataUrl = 'data:image/png;base64,' . $base64Data;
                            @endphp


                            <input type="file" name='app_footer_logo' id='app_footer_logo' class=" my-3 form-control "  accept="image/*" onchange="previewImage()" required>
                            <img id="preview-image"  src="{{ $dataUrl }}" alt="Base64 Image" width="300">

                            @if ($errors->has('app_footer_logo'))
                            @error('app_footer_logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select app footer logo.
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="my-3 btn btn-lg btn-success btn-submit"><i class="fa fa-save"></i> Save Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
       function previewImage() {
            var input = document.getElementById('app_footer_logo');
            var preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>