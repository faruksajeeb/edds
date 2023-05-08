@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Sub Answer
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Create Sub Answer</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('sub_answers') }}">Sub Answers</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('sub_answers.store') }}" method="POST" class="needs-validation"
                        novalidate>
                        @csrf
                        <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Answer</label>
                            <select name="answer_id" id="answer_id" class="form-select" required>
                                <option value="">--select answer--</option>
                                @foreach ($answers as $val)
                                    <option value="{{ $val->id }}" {{ $val->id==old('answer_id')?'selected':''}}>{{ $val->value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('answer_id'))
                                @error('answer_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select answer.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value')) has-error @endif fw-bold">Value *</label><br />
                            <textarea name='value' id='value' class="form-control @error('value') is-invalid @enderror"
                                placeholder="Enter answer value" rows="3" required>{{ old('value') }}</textarea>
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
                                placeholder="Enter answer value in bangla" rows="3">{{ old('value_bangla') }}</textarea>
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
        </script>
    @endpush
</x-app-layout>
