<x-app-layout>
    <x-slot name="title">
        Sub Questions
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                @if (request()->get('status') == 'archived')
                                    Archived
                                @endif Sub Questions
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                            Archived
                                        @endif Sub Questions
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                                <a href="{{ url('/sub_questions?status=archived') }}">Archived Sub Questions</a>
                            @else
                                <a href="{{ url('/sub_questions') }}">Sub Questions</a>
                            @endif
                            @if ( (request()->get('status') == 'archived') && ($sub_questions->total() >0))
                                @can('sub_question.restore')
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="{{ route('sub_questions.restore-all') }}"
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
                                <div class="col-md-3 col-sm-12">
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="1">Active
                                        </option>
                                        <option value="-1">Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <a href='{{ request()->get('status') == 'archived' ? url('/sub_questions?status=archived') : url('/sub_questions') }}'
                                                class="btn btn-xs btn-primary me-1"><i class="fa fa-refresh"></i></a>
                                            @can('sub_question.export')
                                                {{-- <button class="btn btn-xs btn-danger float-end " name="submit_btn"
                                                value="pdf" type="submit">
                                                <i class="fa-solid fa-download"></i> PDF
                                            </button> --}}
                                                <button class="btn btn-xs btn-info float-end me-1" name="submit_btn"
                                                    value="csv" type="submit">
                                                    <i class="fa-solid fa-download"></i> CSV
                                                </button>

                                                <button class="btn btn-xs btn-success float-end me-1" name="submit_btn"
                                                    value="export" type="submit">
                                                    <i class="fa-solid fa-download"></i> Export
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    @can('sub_question.create')
                                        <a href="{{ route('sub_questions.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Sub Question
                                        </a>
                                    @endcan
                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Value</th>
                                    <th>Value Bangla</th>
                                    <th>Question</th>
                                    <th>Input Method</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_questions as $index => $val)
                                    <tr>
                                        <td>{{ $index + $sub_questions->firstItem() }}</td>
                                        <td>{{ $val->value }}</td>
                                        <td>{{ $val->value_bangla }}</td>
                                        <td>{{ isset($val->question) ? $val->question->value : '' }}</td>
                                        <td>{{ $val->input_method }}</td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                    <span class="badge bg-secondary">Archived</span>
                                                @else
                                                    @can('sub_question.edit')
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="{{ $val->status }}"
                                                            {{ $val->status == -1 ? '' : '' }} table="sub_questions"
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
                                @can('sub_question.restore')
                                    <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}"
                                        onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-{{ $val->id }}"
                                        action="{{ route('sub_questions.restore', Crypt::encryptString($val->id)) }}"
                                        method="POST" style="display: none">
                                        @method('POST')
                                        @csrf
                                    </form>
                                @endcan
                                {{-- force delete button --}}
                                @can('sub_question.force_delete')
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('sub_questions.force-delete', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @else
                                {{-- edit button --}}
                                @can('sub_question.edit')
                                    @if ($val->status == 1)
                                        <a href="{{ route('sub_questions.edit', Crypt::encryptString($val->id)) }}"
                                            class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                    @endif
                                @endcan
                                {{-- delete button --}}
                                @can('sub_question.delete')
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('sub_questions.destroy', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @endif

                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        {{ $sub_questions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>

        @push('scripts')
            <script></script>
        @endpush
    </x-app-layout>
