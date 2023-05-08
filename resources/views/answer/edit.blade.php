@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Answer
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Answer</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('answer') }}">Answers</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('answers.update', Crypt::encryptString($answerInfo->id)) }}"
                        method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Question</label>
                            <select name="question_id" id="question_id" class="form-select" required>
                                <option value="">--select questions--</option>
                                @foreach ($questions as $val)                                    
                                    <option value="{{$val->id}}" {{ ($val->id==old('question_id',$answerInfo->question_id)) ?'selected':''}}>{{$val->value}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('question_id'))
                                @error('question_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select question.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value')) has-error @endif fw-bold">Value *</label><br />
                            <textarea name='value' id='value' class="form-control @error('value') is-invalid @enderror"
                                placeholder="Enter question value" rows="3" required>{{ old('value',$answerInfo->value) }}</textarea>
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
                                placeholder="Enter question value in bangla" rows="3">{{ old('value_bangla',$answerInfo->value_bangla) }}</textarea>
                        </div>
                       
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit">Save Changes</button>
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
