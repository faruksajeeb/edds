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
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="{{ route('questions.restore-all') }}"
                                            style="display:inline" method="POST">
                                            @method('POST')
                                            @csrf
                                        </form>
                                    </div>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="status"
                                value="{{ request()->get('status') == 'archived' ? 'archived' : '' }}">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 px-0 input-group">
                                    <select name="search_category" class="form-select" id="search_category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request()->get('search_category') == $category->id ? 'selected' : '' }}>{{ $category->option_value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="search_respondent" class="form-select" id="search_respondent">
                                        <option value="">Select Respondent</option>
                                        @foreach ($respondents as $respondent)
                                            <option value="{{ $respondent->option_value }}" {{ request()->get('search_respondent') == $respondent->option_value ? 'selected' : '' }}>
                                                {{ $respondent->option_value }}</option>
                                        @endforeach
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ request()->get('search_status') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="-1" {{ request()->get('search_status') == '-1' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="{{request()->get('search_text')}}" class="form-control"
                                        placeholder="Search by value, value bangla">
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 input-group mt-1">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit"
                                        value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='{{ request()->get('status') == 'archived' ? url('/questions?status=archived') : url('/questions') }}'
                                        class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i> Refresh</a>
                                    @can('question.export')
                                        {{-- <button class="btn btn-xs btn-danger float-end me-1 export_btn" name="submit_btn" value="pdf"
                                            type="submit">
                                            <i class="fa-solid fa-download"></i> PDF
                                        </button>
                                        <button class="btn btn-xs btn-info float-end me-1 export_btn" name="submit_btn" value="csv"
                                            type="submit">
                                            <i class="fa-solid fa-download"></i> CSV
                                        </button> --}}

                                        <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn"
                                            value="export" type="submit">
                                            <i class="fa-solid fa-download"></i> Export
                                        </button>
                                    @endcan
                                    @can('question.create')
                                        <a href="{{ route('questions.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Question
                                        </a>
                                    @endcan
                                </div>
                                <div class="col-md-3 col-sm-12 px-0">
                                    <div class="input-group">
                                        <div class="input-group-append">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">

                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Value</th>
                                    <th>Value Bangla</th>
                                    <th>Category</th>
                                    <th>Respondent</th>
                                    <th>Input Method</th>
                                    {{-- <th>Created At</th>
                                    <th>Updated At</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($questions as $index => $val)
                                    <tr>
                                        <td>{{ $index + $questions->firstItem() }}</td>
                                        <td>{{ $val->value }}</td>
                                        <td>{{ $val->value_bangla }}</td>
                                        <td>{{ optional($val->option)->option_value }}</td>
                                        <td>{{ $val->respondent }}</td>
                                        <td>{{ $val->input_method }}</td>
                                        {{-- <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td> --}}
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                    <span class="badge bg-secondary">Deleted</span>
                                                @else
                                                    @can('question.edit')
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="{{ $val->status }}"
                                                            {{ $val->status == -1 ? '' : '' }} table="questions"
                                                            type="checkbox" id="row_{{ $val->id }}"
                                                            value="{{ Crypt::encryptString($val->id) }}"
                                                            {{ $val->status == 1 ? 'checked' : '' }}
                                                            style="cursor:pointer">
                                                    @endif
                                    @endif
                        </div>
                        </td>
                        <td class="text-nowrap">
                            @if (request()->get('status') == 'archived')
                                {{-- restore button --}}
                                @can('question.restore')
                                    <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}"
                                        onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-{{ $val->id }}"
                                        action="{{ route('questions.restore', Crypt::encryptString($val->id)) }}"
                                        method="POST" style="display: none">
                                        @method('POST')
                                        @csrf
                                    </form>
                                @endcan
                                {{-- force delete button --}}
                                @can('question.force_delete')
                                    <a href="" class="disabled btn btn-danger btn-sm btn-force-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i
                                            class="fa-solid fa-remove "></i> Force Delete</a>
                                    <form id="force-delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('questions.force-delete', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @else
                                {{-- edit button --}}
                                @can('question.edit')
                                    @if ($val->status == 1)
                                        <a href="{{ route('questions.edit', Crypt::encryptString($val->id)) }}"
                                            class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                    @endif
                                @endcan
                                {{-- delete button --}}
                                @can('question.delete')
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('questions.destroy', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @endif

                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No records found. </td>
                        </tr>
                        @endforelse
                        </tbody>
                        </table>
                        {{ $questions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>

        @push('scripts')
            <script></script>
        @endpush
    </x-app-layout>
