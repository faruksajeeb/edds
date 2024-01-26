@push('styles')
<style>

</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Tips
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit tips</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('tips') }}">Tips</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tips.update',Crypt::encryptString($editInfo->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('tips_english')) has-error @endif fw-bold">Tips in
                                English <span class="text-danger">*</span></label><br />
                            <input type="text" name='tips_english' id='tips_english' class="form-control @error('tips_english') is-invalid @enderror" placeholder="Enter tips in english" value="{{ old('tips_english',$editInfo->tips_english) }}" required>
                            @if ($errors->has('tips_english'))
                            @error('tips_english')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a tips name in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('tips_bangla')) has-error @endif fw-bold">Tip in Bangla <span class="text-danger">*</span> </label><br />
                            <input type="text" name='tips_bangla' id='tips_bangla' class="form-control @error('tips_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে পরামর্শ বাংলায় লিখুন" value="{{ old('tips_bangla',$editInfo->tips_bangla) }}" required>
                            @if ($errors->has('tips_bangla'))
                            @error('tips_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a tips name in Bangla.
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