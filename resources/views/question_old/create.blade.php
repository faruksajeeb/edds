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
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Category <span class='text-danger'>*<span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">--select category--</option>
                                @foreach ($categories as $val)
                                    <option value="{{ $val->id }}"
                                        {{ $val->id == old('category_id') ? 'selected' : '' }}>{{ $val->option_value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select a category.
                                </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Respondent <span class='text-danger'>*<span></label>
                            <select name="respondent[]" id="respondent" class="form-select  js-states select2"
                                multiple="multiple" data-placeholder="Select one or more..." required>
                                @foreach ($respondents as $val)
                                    <option value="{{ $val->option_value }}"
                                        {{ old('respondent') !== null && in_array($val->option_value, old('respondent')) ? 'selected' : '' }}>
                                        {{ $val->option_value }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('respondent'))
                                @error('respondent')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select one or more respondent.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value')) has-error @endif fw-bold">Value <span class='text-danger'>*<span></label><br />
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
                                Bangla <span class='text-danger'>*<span></label><br />
                            <textarea name='value_bangla' id='value_bangla' class="form-control @error('value_bangla') is-invalid @enderror"
                                placeholder="Enter question value in bangla" rows="3" required>{{ old('value_bangla') }}</textarea>
                            @if ($errors->has('value_bangla'))
                                @error('value_bangla')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please enter a value bangla.
                                </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Input Method
                                <span class='text-danger'>*<span></label>
                            <select name="input_method" id="input_method" class="form-select" onchange="showInputType(this.value)" required>
                                <option value="">--select input method--</option>
                                <option value="text_box" {{ old('input_method') == 'text_box' ? 'selected' : '' }}>Text
                                    Box
                                </option>
                                <option value="select_box" {{ old('input_method') == 'select_box' ? 'selected' : '' }}>
                                    Select
                                    Box</option>
                                <option value="check_box" {{ old('input_method') == 'check_box' ? 'selected' : '' }}>
                                    Checkbox
                                </option>
                                <option value="radio_button"
                                    {{ old('input_method') == 'radio_button' ? 'selected' : '' }}>
                                    Radio Button
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

                        <div class="form-group my-1 input_type_section">
                            <label for=""
                                class="@if ($errors->has('input_type')) has-error @endif fw-bold">Input Type
                                *</label>
                            <select name="input_type" id="input_type" class="form-select" >
                                <option value="">--select input type--</option>
                                {{-- <option value="alphabetic" {{ old('input_type', $questionInfo->input_type) == 'alphabetic' ? 'selected' : '' }}>Alphabetic
                                </option> --}}
                                <option value="alphanumeric"
                                    {{ old('input_type') == 'alphanumeric' ? 'selected' : '' }}>
                                    Alphanumeric</option>
                                <option value="numeric"
                                    {{ old('input_type') == 'numeric' ? 'selected' : '' }}>
                                    Numeric
                                </option>
                            </select>
                            @if ($errors->has('input_type'))
                                @error('input_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select input type.
                                </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('is_required')) has-error @endif fw-bold">Is Required? <span class='text-danger'>*<span></label>
                            <select name="is_required" id="is_required" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes" {{ old('is_required') == 'yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="no" {{ old('is_required') == 'no' ? 'selected' : '' }}>
                                    No</option>
                            </select>
                            @if ($errors->has('is_required'))
                                @error('is_required')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select one.
                                </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('image_require')) has-error @endif fw-bold">Show Image Field? <span class='text-danger'>*<span></label>
                            <select name="image_require" id="image_require" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes" {{ old('image_require') == 'yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="no" {{ old('image_require') == 'no' ? 'selected' : '' }}>
                                    No</option>
                            </select>
                            @if ($errors->has('image_require'))
                                @error('image_require')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select one.
                                </div>
                            @endif
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn"
                                class="btn btn-lg btn-success btn-submit">Save</button>
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
            let inputMethodVal = $("#input_method").val();
            if(inputMethodVal=='text_box'){
                $('.input_type_section').show();
                $("#input_type").prop('required',true);
            }else{
                $('.input_type_section').hide();
                $("#input_type").prop('required',false);
            }
            const showInputType = (val)=> {
                
                if(val=='text_box'){
                    $('.input_type_section').show('slow');
                    $("#input_type").prop('required',true);
                }else{
                    $('.input_type_section').hide('slow');
                    $("#input_type").prop('required',false);
                }
            }
        </script>
    @endpush
</x-app-layout>
