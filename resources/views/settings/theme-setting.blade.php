<x-app-layout>
    <x-slot name="title">
        Theme Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3 my-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Theme Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="{{ route('theme-setting') }}" method="POST" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="form-group row py-1">
                        <label class="col-lg-3 col-form-label">Website Name</label>
                        <div class="col-lg-9">
                            <input name="website_name"
                                class="form-control   @error('website_name') is-invalid @enderror"
                                value="{{ $themeSettings ? $themeSettings->website_name : old('website_name') }}"
                                type="text" required>
                            <div class="invalid-feedback">Website Name is required!</div>
                            @error('website_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Website Logo</label>
                        <div class="col-lg-7">
                            <input type="file" name="website_logo" id="website_logo"
                                class="form-control   @error('website_logo') is-invalid @enderror"
                                value="{{ $themeSettings ? $themeSettings->website_logo : old('website_logo') }}"
                                required>
                            <div class="invalid-feedback">Website logo is required!</div>
                            @error('website_logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="form-text text-muted">Recommended image size is 40px x 40px</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="img-thumbnail float-end"><img id="website_logo_preview"
                                    src="uploads/{{ $themeSettings ? $themeSettings->website_logo : old('website_logo') }}"
                                    alt="" width="40" height="40"></div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Favicon</label>
                        <div class="col-lg-7">
                            <input type="file" name="website_favicon" id="website_favicon"
                                class="form-control   @error('website_favicon') is-invalid @enderror" required>
                            <div class="invalid-feedback">Website favicon is required!</div>
                            @error('website_favicon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="form-text text-muted">Recommended image size is 16px x 16px</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="settings-image img-thumbnail float-end">
                                <img id="website_favicon_preview" src="uploads/{{ $themeSettings ? $themeSettings->website_favicon : old('website_favicon') }}" class="img-fluid" width="16" height="16" alt="">
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="submit-section">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button class="btn btn-lg btn-outline-secondary submit-btn rounded-pill">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            website_logo.onchange = evt => {
                const [file] = website_logo.files
                if (file) {
                    website_logo_preview.src = URL.createObjectURL(file)
                }
            }

            website_favicon.onchange = evt => {
                const [file] = website_favicon.files
                if (file) {
                    website_favicon_preview.src = URL.createObjectURL(file)
                }
            }
        </script>
    @endpush

</x-app-layout>
