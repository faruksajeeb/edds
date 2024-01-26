@push('styles')
<style>

</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Help
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Add Help</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('helps') }}">Helps</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('helps.store') }}" method="POST" class="needs-validation" novalidate>
                       
                        @csrf
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('page_name')) has-error @endif fw-bold">Page <span class='text-danger'>*<span></label>
                            <select name="page_name" id="page_name" class="form-select" required>
                                <option value="">--select page name--</option>
                                @php
                                $pages = array('login_page','registration_page','startup_page','otp_page','pin_page','local_data_page','report_page','question_page','app_slogan');
                                @endphp
                                @foreach ($pages as $val)
                                <option value="{{$val}}" {{ old('page_name') == $val ? 'selected' : '' }}>{{$val}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('page_name'))
                            @error('page_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select a page name.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('help_english')) has-error @endif fw-bold">Help in
                                English <span class="text-danger">*</span></label><br />
                                <textarea rows="5" name='help_english' id='help_english' class="form-control @error('help_english') is-invalid @enderror" placeholder="Enter help in english" required>{{ old('help_english') }}</textarea>
                            @if ($errors->has('help_english'))
                            @error('help_english')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a help name in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('help_bangla')) has-error @endif fw-bold">Help in Bangla <span class="text-danger">*</span> </label><br />
                            <textarea rows="5" name='help_bangla' id='help_bangla' class="form-control @error('help_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে পরামর্শ বাংলায় লিখুন" required>{{ old('help_bangla') }}</textarea >
                            @if ($errors->has('help_bangla'))
                            @error('help_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a help name in Bangla.
                            </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('answare_bangla')) has-error @endif fw-bold">Question <span class='text-danger'><span></label>
                            <select name="question_id" id="question_id" class="form-select" >
                                <option value="">--select questions--</option>
                                @foreach ($questions as $val)
                                <option value="{{$val->id}}" {{ old('question_id') == $val->id ? 'selected' : '' }}>{{$val->question}} ({{$val->question_bangla}})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('question_id'))
                            @error('question_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select a question.
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