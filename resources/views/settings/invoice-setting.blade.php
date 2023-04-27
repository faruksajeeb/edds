<x-app-layout>
    <x-slot name="title">
        Invoice Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Invoice Settings</h3>
                        </div>
                    </div>
                </div>

                <form  action="{{ route('invoice-setting') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="form-group row my-3">
                        <label class="col-lg-3 col-form-label">Invoice prefix</label>
                        <div class="col-lg-9">
                            <input name="invoice_prefix" type="text" value="{{ $invoiceSettings ? $invoiceSettings->invoice_prefix : old('invoice_prefix') }}" class="form-control @error('invoice_prefix') is-invalid @enderror" required>
                            <div class="invalid-feedback">Invoice prefix is required!</div>
                            @error('invoice_prefix')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row my-3">
                        <label class="col-lg-3 col-form-label">Invoice Logo</label>
                        <div class="col-lg-7">
                            <input type="file" name="invoice_logo" id="invoice_logo" value="{{ $invoiceSettings ? $invoiceSettings->invoice_logo : old('invoice_logo') }}" class="form-control @error('invoice_logo') is-invalid @enderror" required>
                            <div class="invalid-feedback">Invoice prefix is required!</div>
                            @error('invoice_logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="form-text text-muted">Recommended image size is 200px x 40px</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="img-thumbnail float-end">
                                <img id="invoice_logo_preview" src="uploads/{{ $invoiceSettings ? $invoiceSettings->invoice_logo : old('invoice_logo') }}" class="img-fluid"
                                    alt="" width="140" height="40"></div>
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
            invoice_logo.onchange = evt => {
                const [file] = invoice_logo.files
                if (file) {
                    invoice_logo_preview.src = URL.createObjectURL(file)
                }
            }
        </script>
    @endpush
</x-app-layout>
