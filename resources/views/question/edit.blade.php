@push('styles')
<style>

</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Question
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="background-color: #ECF4D6;">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Edit Question</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"> Question & Answer </a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('questions') }}"> Questions </a></li>
                                    <li class="breadcrumb-item " aria-current="page"> Edit </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.update', Crypt::encryptString($questionInfo->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="currentPage" value="{{$currentPage}}">
                        <div class="form-group mb-3">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Type Of Category
                                <span class='text-danger'>*<span></label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">--select category--</option>
                                <option value="0" {{($questionInfo->category_id==0)?'selected':''}}>General Category</option>
                                @foreach ($categories as $val)
                                    <option value="{{ $val->id }}"
                                        {{ $val->id == old('category_id', $questionInfo->category_id) ? 'selected' : '' }}>
                                        {{ $val->option_value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select category.
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="respondent_type" class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Respondent Types<span class='text-danger'>*<span></label>
                            <select name="respondent_type[]" id="respondent_type" class="form-select select2" data-placeholder="Select one or more..."  multiple required>
                                
                                @foreach($respondent_types as $respondent_type)
                                <option value="{{$respondent_type->option}}" {{ in_array($respondent_type->option,explode(",",old('respondent_type',$questionInfo->respondent_type)))?'selected':''}}>{{$respondent_type->option}}</option>
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
                        <div class="form-group mb-3">
                            <label for="" class="@if ($errors->has('question')) has-error @endif fw-bold">Qusetion in English <span class='text-danger'>*<span></label><br />
                            <textarea name='question' id='question' class="form-control @error('question') is-invalid @enderror" placeholder="Enter question in English" rows="3" required>{{ old('question', $questionInfo->question) }}</textarea>
                            @if ($errors->has('question'))
                            @error('question')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a question in english.
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="@if ($errors->has('question_bangla')) has-error @endif fw-bold">Qusetion
                                in Bangla <span class='text-danger'>*<span></label><br />
                            <textarea name='question_bangla' id='question_bangla' class="form-control @error('question_bangla') is-invalid @enderror" placeholder="Enter question in Bangla" rows="3" required>{{ old('question_bangla', $questionInfo->question_bangla) }}</textarea>
                            @if ($errors->has('question_bangla'))
                            @error('question_bangla')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please enter a question in bangla.
                            </div>
                            @endif
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('question_bangla')) has-error @endif fw-bold">Related To
                                <span class='text-danger'>*<span></label>
                            <select name="related_to" id="related_to" class="form-select" onchange="showQuestion(this.value)" required>
                                <option value="">--select related to--</option>
                                <option value="level1" {{ old('related_to',$questionInfo->related_to) == 'level1' ? 'selected' : '' }}>Level 1</option>
                                <option value="question" {{ old('related_to',$questionInfo->related_to) == 'question' ? 'selected' : '' }}>Question</option>
                                <option value="answare" {{ old('related_to',$questionInfo->related_to) == 'answare' ? 'selected' : '' }}>Answer</option>
                            </select>
                            @if ($errors->has('related_to'))
                            @error('related_to')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select related to.
                            </div>
                            @endif
                        </div>
                        <div class="form-group my-3 relation_section">
                            <label for="" class="@if ($errors->has('question_bangla')) has-error @endif fw-bold">Relation With
                                <span class='text-danger'>*<span></label>
                            <select name="relation_id" id="relation_id" class="form-select" required>
                                    <!-- get by JS -->
                            </select>
                            @if ($errors->has('relation_id'))
                            @error('relation_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select relation.
                            </div>
                            @endif
                        </div>

                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('question_bangla')) has-error @endif fw-bold">Answer Type
                                <span class='text-danger'>*<span></label>
                            <select name="answare_type" id="answare_type" class="form-select" onchange="showInputType(this.value)" required>
                                <option value="">--select answer type--</option>
                                <option value="checkbox" {{ old('answare_type',$questionInfo->answare_type) == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                <option value="radio" {{ old('answare_type',$questionInfo->answare_type) == 'radio' ? 'selected' : '' }}>Radio Button</option>
                                <option value="input" {{ old('answare_type',$questionInfo->answare_type) == 'input' ? 'selected' : '' }}>Input Field
                                <option value="image" {{ old('answare_type',$questionInfo->answare_type) == 'image' ? 'selected' : '' }}>Image
                                <option value="label" {{ old('answare_type',$questionInfo->answare_type) == 'label' ? 'selected' : '' }}>Label
                                </option>
                            </select>
                            @if ($errors->has('answare_type'))
                            @error('answare_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @else
                            <div class="invalid-feedback">
                                Please select answer type.
                            </div>
                            @endif
                        </div>

                        <div class="form-group my-2 input_type_section">
                            <label for="" class="@if ($errors->has('input_type')) has-error @endif fw-bold">Input Type
                                <span class='text-danger'>*<span></label>
                            <select name="input_type" id="input_type" class="form-select">
                                <option value="">--select input type--</option>
                                <option value="text" {{ old('input_type',$questionInfo->input_type) == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="alphanumeric" {{ old('input_type',$questionInfo->input_type) == 'alphanumeric' ? 'selected' : '' }}>
                                    Alphanumeric</option>
                                <option value="numeric" {{ old('input_type',$questionInfo->input_type) == 'numeric' ? 'selected' : '' }}>
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
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('is_required')) has-error @endif fw-bold">Is Required? <span class='text-danger'>*<span></label>
                            <select name="is_required" id="is_required" class="form-select" required>
                                <option value="">--select one--</option>
                                <option value="yes" {{ old('is_required',$questionInfo->is_required) == 'yes' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="no" {{ old('is_required',$questionInfo->is_required) == 'no' ? 'selected' : '' }}>
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
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('info')) has-error @endif fw-bold">Info<span class='text-danger'><span></label>
                            <input type="text" name="info" id="info" value="{{old('info',$questionInfo->info)}}" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('info_bangla')) has-error @endif fw-bold">Info Bangla<span class='text-danger'><span></label>
                            <input type="text" name="info_bangla" id="info_bangla" value="{{old('info_bangla',$questionInfo->info_bangla)}}" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('sub_info')) has-error @endif fw-bold">Sub Info<span class='text-danger'><span></label>
                            <input type="text" name="sub_info" id="sub_info" value="{{old('sub_info',$questionInfo->sub_info)}}" class="form-control"/>                            
                        </div>
                        <div class="form-group my-3">
                            <label for="" class="@if ($errors->has('sub_info_bangla')) has-error @endif fw-bold">Sub Info Bangla<span class='text-danger'><span></label>
                            <input type="text" name="sub_info_bangla" id="sub_info_bangla" value="{{old('sub_info_bangla',$questionInfo->sub_info_bangla)}}" class="form-control"/>                            
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success btn-submit"><i class="fa fa-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function() {

            updateOptions("{{$questionInfo->related_to}}");

        });
        
        let relatedTo = $("#related_to").val();
        
        if (relatedTo && relatedTo != 'level1') {
            $('.relation_section').show();
            $("#relation_id").prop('required', true);
        } else {           
            $('.relation_section').hide();
            $("#relation_id").prop('required', false);
        }


        let inputMethodVal = $("#answare_type").val();
        if (inputMethodVal == 'input') {
            $('.input_type_section').show();
            $("#input_type").prop('required', true);
        } else {
            $('.input_type_section').hide();
            $("#input_type").prop('required', false);
        }

        function updateOptions(type) {
            // alert(type);
            var questionOptions = <?php echo json_encode($questions); ?>;
            var answerOptions = <?php echo json_encode($answers); ?>;



            var options = type === 'question' ? questionOptions : answerOptions;
            var optionsSelect = $('#relation_id');

            // Clear existing options
            optionsSelect.empty();

            // Add new options
            optionsSelect.append($('<option>', {
                    value: '',
                    text: type === 'question' ? '--select question--' : '--select answer--'
                }));
            $.each(options, function(index, value) {
                optionsSelect.append($('<option>', {
                    value: value.id,
                    text: type === 'question' ? value.question + ' ('+value.question_bangla+')' : value.answare + ' ('+value.answare_bangla+')'
                }));
            });
            $('#relation_id').val('{{$questionInfo->relation_id}}');

        }

        const showQuestion = (val) => {
            if (val != 'level1') {
                updateOptions(val);
                $('.relation_section').show('slow');
                // if (val == 'question') {
                //     $('#question_section').show();
                //     $('#answer_section').hide();
                // } else if (val == 'answare') {
                //     $('#answer_section').show();
                //     $('#question_section').hide();
                // }
                $("#relation_id").prop('required', true);
            } else {
                $('.relation_section').hide('slow');
                $("#relation_id").prop('required', false);
            }
        }

        const showInputType = (val) => {
            if (val == 'input') {
                $('.input_type_section').show('slow');
                $("#input_type").prop('required', true);
            } else {
                $('.input_type_section').hide('slow');
                $("#input_type").prop('required', false);
            }
        }
    </script>
    @endpush
</x-app-layout>