@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Question
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Create Question</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('questions') }}">Questions</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Category*</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">--select category--</option>
                                @foreach ($categories as $val)                                    
                                    <option value="{{$val->id}}" {{ $val->id==old('responden_id')?'selected':''}}>{{$val->option_value}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select respondent.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value')) has-error @endif fw-bold">Value *</label><br />
                            <textarea name='value' id='value' class="form-control @error('value') is-invalid @enderror"
                                placeholder="Enter question value" rows="3" required>{{ old('value') }}</textarea>
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
                        <div class="form-group">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Value
                                Bangla</label><br />
                            <textarea name='value_bangla' id='value_bangla' class="form-control @error('value_bangla') is-invalid @enderror"
                                placeholder="Enter question value in bangla" rows="3">{{ old('value_bangla') }}</textarea>
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Input Method
                                *</label>
                            <select name="input_method" id="input_method" class="form-select" required>
                                <option value="">--select input method--</option>
                                <option value="textbox" {{ old('input_method') == 'textbox' ? 'selected' : '' }}>Text Box
                                </option>
                                <option value="selectbox" {{ old('input_method') == 'selectbox' ? 'selected' : '' }}>Select
                                    Box</option>
                                <option value="checkbox" {{ old('input_method') == 'checkbox' ? 'selected' : '' }}>Checkbox
                                </option>
                            </select>
                            @if ($errors->has('input_method'))
                                @error('input_method')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select input method.
                                </div>
                            @endif
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
