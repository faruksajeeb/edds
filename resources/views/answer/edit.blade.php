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
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Answer</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('answers') }}">Answers</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('answers.update', Crypt::encryptString($answerInfo->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="currentPage" value="{{$currentPage}}">
                        <div class="form-group mb-3">
                            <label for="respondent_type" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Respondent Types<span class='text-danger'>*<span></label>
                            <select name="respondent_type[]" id="respondent_type" class="form-select select2" data-placeholder="Select one or more..." multiple required>

                                @foreach($respondent_types as $respondent_type)
                                <option value="{{$respondent_type->option}}" {{ in_array($respondent_type->option,explode(",",old('respondent_type',$answerInfo->respondent_type)))?'selected':''}}>{{$respondent_type->option}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('respondent_type'))
                            @error('respondent_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select a respondent_type.
                            </div>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label for="" class="@if ($errors->has('answare_bangla')) has-error @endif fw-bold">Question <span class='text-danger'>*<span></label>
                            <select name="question_id" id="question_id" class="form-select" required>
                                <option value="">--select questions--</option>
                                @foreach ($questions as $val)
                                <option value="{{$val->id}}" {{ old('question_id',$answerInfo->question_id) == $val->id ? 'selected' : '' }}>{{$val->question}} ({{$val->question_bangla}})</option>
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
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('answare')) has-error @endif fw-bold">Answer in English <span class='text-danger'>*<span></label><br />
                            <textarea name='answare' id='answare' class="form-control @error('answare') is-invalid @enderror" placeholder="Enter answer in English" rows="3" required>{{ old('answare',$answerInfo->answare) }}</textarea>
                            @if ($errors->has('answare'))
                            @error('answare')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter an answer in English.
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="@if ($errors->has('answare_bangla')) has-error @endif fw-bold">Answer in
                                Bangla <span class='text-danger'>*<span></label><br />
                            <textarea name='answare_bangla' id='answare_bangla' class="form-control @error('answare_bangla') is-invalid @enderror" placeholder="অনুগ্রহ করে বাংলায় লিখুন" rows="3" required>{{ old('answare_bangla',$answerInfo->answare_bangla) }}</textarea>
                            @if ($errors->has('answare_bangla'))
                            @error('answare_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter an answer in Bangla.
                            </div>
                            @endif
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