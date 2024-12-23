@push('styles')
<style>
    .drag-icon {
        font-size: 25px;
        color: darkgray;
        cursor: pointer;
    }
</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Questions
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                @if (request()->get('status') == 'archived')
                                Deleted
                                @endif Questions
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                        Deleted
                                        @endif Questions
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                            <a href="{{ url('/questions?status=archived') }}">Deleted Questions</a>
                            @else
                            <a href="{{ url('/questions') }}">Questions</a>
                            @endif
                            @if (request()->get('status') == 'archived' && $questions->total() > 0)
                            @can('question.restore')
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="{{ route('questions.restore-all') }}" style="display:inline" method="POST">
                                    @method('POST')
                                    @csrf
                                </form>
                            </div>
                            @endcan
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body py-1">
                    <div class="">
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="status" value="{{ request()->get('status') == 'archived' ? 'archived' : '' }}">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 px-0 input-group">
                                    <select name="search_category" class="form-select" id="search_category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id}}" {{ request()->get('search_category') == $category->id ? 'selected' : '' }}>{{ $category->option_value}}</option>
                                        @endforeach
                                    </select>
                                    <select name="search_respondent_type" class="form-select" id="search_respondent_type">
                                        <option value="">Select Respondent Type</option>
                                        @foreach($respondent_types as $respondent_type)
                                        <option value="{{ $respondent_type->option}}" {{ request()->get('search_respondent_type') == $respondent_type->option ? 'selected' : '' }}>{{ $respondent_type->option}}</option>
                                        @endforeach
                                    </select>
                                    <select name="search_related_to" class="form-select" id="search_related_to">
                                        <option value="">Select Related To</option>
                                        <option value="question" {{ request()->get('search_related_to') == 'question' ? 'selected' : '' }}>Question
                                        </option>
                                        <option value="answare" {{ request()->get('search_related_to') == 'answare' ? 'selected' : '' }}>Answer
                                        </option>
                                        <option value="level1" {{ request()->get('search_related_to') == 'level1' ? 'selected' : '' }}>Level 1
                                        </option>
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7" {{ request()->get('search_status') == '7' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="-7" {{ request()->get('search_status') == '-7' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="{{ request()->get('search_text') }}" class="form-control" placeholder="Search by value, value bangla">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-9 px-0 mt-1">
                                    <div class="input-group">
                                        <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit" value="search">
                                            <i class="fa fa-search"></i> Filter Data
                                        </button>
                                        <a href='{{ request()->get('status') == 'archived' ? url('/questions?status=archived') : url('/questions') }}' class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                            Refresh</a>
                                        @can('question.export')
                                        {{-- <button class="btn btn-xs btn-danger float-end me-1 export_btn" name="submit_btn" value="pdf"
                                            type="submit">
                                            <i class="fa-solid fa-download"></i> PDF
                                        </button>
                                        <button class="btn btn-xs btn-info float-end me-1 export_btn" name="submit_btn" value="csv"
                                            type="submit">
                                            <i class="fa-solid fa-download"></i> CSV
                                        </button> --}}

                                        <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn" value="export" type="submit">
                                            <i class="fa-solid fa-download"></i> Export
                                        </button>
                                        @endcan
                                        @can('question.create')
                                        <a href="{{ route('questions.create') }}" class="btn btn-xs btn-outline-primary float-end" name="create_new" type="button">
                                            <i class="fa-solid fa-plus"></i> Create Question
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- Show entries dropdown -->
                                    <div class="float-end mt-2">
                                        <form action="{{ url()->current() }}" method="GET">
                                            <label for="perPage">Show
                                                <select name="perPage" id="perPage" onchange="this.form.submit()">
                                                    <option value="5" {{ Request::get('perPage') == 5 ? 'selected' : '' }}>5</option>
                                                    <option value="10" {{ Request::get('perPage') == 10 ? 'selected' : '' }}>10
                                                    </option>
                                                    <option value="25" {{ Request::get('perPage') == 25 ? 'selected' : '' }}>25
                                                    </option>
                                                    <option value="50" {{ Request::get('perPage') == 50 ? 'selected' : '' }}>50
                                                    </option>
                                                    <option value="100" {{ Request::get('perPage') == 100 ? 'selected' : '' }}>100
                                                    </option>
                                                    <!-- Add more options if needed -->
                                                </select> entries</label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive py-3">
                            <table class="table table-sm mb-0 table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" colspan="2">Order</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Question</th>
                                        <th class="text-nowrap">Question Bangla</th>
                                        <th class="text-nowrap">Category</th>
                                        <th class="text-nowrap">Respondent Types</th>
                                        <th class="text-nowrap">Related To</th>
                                        <th class="text-nowrap">Relation</th>
                                        <th class="text-nowrap">Answer Type</th>
                                        <th class="text-nowrap">Input Type</th>
                                        <th class="text-nowrap">Is Required</th>
                                        <th class="text-nowrap">Info</th>
                                        <th class="text-nowrap">Info Bangla</th>
                                        <th class="text-nowrap">Sub Info</th>
                                        <th class="text-nowrap">Sub Info Bangla</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" tablename="tbl_q">
                                    @forelse ($questions as $index => $val)
                                    <tr id="{{ $val->id }}">
                                        <td class=''>
                                            <span class="sort bg-red">
                                                <i class="fa-solid fa-up-down-left-right drag-icon"></i>
                                            </span>
                                        </td>
                                        {{-- <td>{{ $index + $questions->firstItem() }}</td> --}}
                                        <td>{{ $val->sl_order }}</td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                <span class="badge bg-secondary">Deleted</span>
                                                @else
                                                @can('question.edit')
                                                <input class="form-check-input active_inactive_btn " status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }} table="tbl_q" type="checkbox" id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}" {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap">{{ $val->question }}</td>
                                        <td class="text-nowrap">{{ $val->question_bangla }}</td>
                                        <td>{{ optional($val->category)->option_value }}</td>
                                        <td class="text-nowrap">{{ $val->respondent_type }}</td>
                                        <td class="text-nowrap">{{ $val->related_to }}</td>
                                        <td class="text-nowrap">
                                            @if($val->related_to=='question')
                                            {{$val->qRelName}}
                                            @elseif($val->related_to=='answare')
                                            {{$val->aRelName}} ({{$val->aRelNameBangla}})
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{$val->answare_type}}</td>
                                        <td class="text-nowrap">{{$val->input_type}}</td>
                                        <td class="text-nowrap">{{$val->is_required}}</td>
                                        <td class="text-nowrap">{{$val->info}}</td>
                                        <td class="text-nowrap">{{$val->info_bangla}}</td>
                                        <td class="text-nowrap">{{$val->sub_info}}</td>
                                        <td class="text-nowrap">{{$val->sub_info_bangla}}</td>


                                        <td class="text-nowrap">
                                            @if (request()->get('status') == 'archived')
                                            {{-- restore button --}}
                                            @can('question.restore')
                                            <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}" onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-{{ $val->id }}" action="{{ route('questions.restore', Crypt::encryptString($val->id)) }}" method="POST" style="display: none">
                                                @method('POST')
                                                @csrf
                                            </form>
                                            @endcan
                                            {{-- force delete button --}}
                                            @can('question.force_delete')
                                            <a href="" class="disabled btn btn-danger btn-sm btn-force-delete-{{ $val->id }}" onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i class="fa-solid fa-remove "></i> Force Delete</a>
                                            <form id="force-delete-form-{{ $val->id }}" style="display: none" action="{{ route('questions.force-delete', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @else
                                            {{-- edit button --}}
                                            @can('question.edit')
                                            @if ($val->status == 7)
                                            <a href="{{ route('questions.edit', [Crypt::encryptString($val->id),'page'=> $questions->currentPage()]) }}" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            @endif
                                            @endcan
                                            {{-- delete button --}}
                                            @can('question.delete')
                                            <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}" onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-{{ $val->id }}" style="display: none" action="{{ route('questions.destroy', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @endif

                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="19" class="text-center">No records found. </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <span class="mt-2">
                            {{ $questions->withQueryString()->links() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let seeMore = (key) => {
            $('#sub_question' + key).toggleClass('h-auto');
            if ($('#expandbtn' + key).hasClass("seemore")) {
                $('#expandbtn' + key).html('see more &#187;');
                $('#expandbtn' + key).removeClass("seemore");
            } else {
                $('#expandbtn' + key).html('see less &#171;');
                $('#expandbtn' + key).addClass("seemore");
            }
        }
    </script>
    @endpush
</x-app-layout>