@push('styles')
<style>

</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Respondent Type
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Respondent Type</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('respondent_types') }}">Respondent Types</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('respondent_types.update', Crypt::encryptString($editInfo->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('option')) has-error @endif fw-bold">Option <span class="text-danger">*</span></label><br />
                            <input name='option' id='option' class="form-control @error('option') is-invalid @enderror" placeholder="Enter option in english" value="{{ old('option',$editInfo->option) }}" required>
                            @if ($errors->has('option'))
                            @error('option')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a option in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('label')) has-error @endif fw-bold">Label in
                                English <span class="text-danger">*</span></label><br />
                            <input name='label' id='label' class="form-control @error('label') is-invalid @enderror" placeholder="Enter label in english" value="{{ old('label',$editInfo->label) }}" required>
                            @if ($errors->has('label'))
                            @error('label')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a label in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('label_bangla')) has-error @endif fw-bold">Label in Bangla <span class="text-danger">*</span> </label><br />
                            <input name='label_bangla' id='label_bangla' class="form-control @error('label_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে বাংলায় লিখুন" value="{{ old('label_bangla',$editInfo->label_bangla) }}" required>
                            @if ($errors->has('label_bangla'))
                            @error('label_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a label name in Bangla.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="sms_code" class="@if ($errors->has('sms_code')) has-error @endif fw-bold">
                                SMS Code <span class="text-danger"></span></label><br />
                            <input type="text" name='sms_code' id='sms_code' class="form-control @error('sms') is-invalid @enderror" placeholder="Enter Sms Code" value="{{ old('sms_code',$editInfo->sms_code) }}">
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