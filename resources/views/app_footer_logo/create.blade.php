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
        Add App Footer Logo
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
                                    <li class="breadcrumb-item"><a href="{{ url('app_footer_logos') }}">app footer logos</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app_footer_logos.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('hospital_name_english')) has-error @endif fw-bold">App Footer Logo <span class="text-danger">*</span></label><br />

                            <input type="file" name='app_footer_logo' id='app_footer_logo' class=" my-3 form-control " accept="image/*" onchange="previewImage()" required>
                            <img id="preview-image" src="" alt=" Select Image" width="300">

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
        var preview = document.getElementById('preview-image');

        function previewImage() {
            var input = document.getElementById('app_footer_logo');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>');

            }
        }
        preview.src = 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>');
    </script>
    @endpush
</x-app-layout>