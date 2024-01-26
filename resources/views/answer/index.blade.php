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
        Answers
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
                                @endif Answers
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Question & Answer</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                        Archived
                                        @endif Answer
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                            <a href="{{ url('/answers?status=archived') }}">Archived Answers</a>
                            @else
                            <a href="{{ url('/answers') }}">Answer</a>
                            @endif
                            @if (request()->get('status') == 'archived')
                            @can('answer.restore')
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="{{ route('answers.restore-all') }}" style="display:inline" method="POST">
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
                            <input type="hidden" name="status" value="{{ request()->get('status') == 'archived' ? 'archived' : '' }}">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 px-0 input-group  mb-1 ">
                                    <select name="search_respondent_type" class="form-select" id="search_respondent_type">
                                        <option value="">Select Respondent Type</option>
                                        @foreach($respondent_types as $respondent_type)
                                        <option value="{{ $respondent_type->option}}" {{ request()->get('search_respondent_type') == $respondent_type->option ? 'selected' : '' }}>{{ $respondent_type->option}}</option>
                                        @endforeach
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7">Active
                                        </option>
                                        <option value="-7">Inactive
                                        </option>
                                    </select>

                                    <input type="text" name="search_text" value="" class="form-control" placeholder="Search by text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 col-sm-12 px-0 ">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn" type="submit" value="search">
                                                <i class="fa fa-search"></i> Filter Data
                                            </button>
                                            <a href='{{ request()->get('status') == 'archived' ? url('/answers?status=archived') : url('/answers') }}' class="btn btn-xs btn-warning me-1"><i class="fa fa-refresh"></i> Refresh</a>
                                            @can('answer.export')
                                            <!-- <button class="btn btn-xs btn-danger float-end " name="submit_btn"
                                                value="pdf" type="submit">
                                                <i class="fa-solid fa-download"></i> PDF
                                            </button>  -->
                                            <!-- <button class="btn btn-xs btn-info float-end me-1" name="submit_btn" value="csv" type="submit">
                                                <i class="fa-solid fa-download"></i> CSV
                                            </button> -->

                                            <button class="btn btn-xs btn-success me-1" name="submit_btn" value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                            @endcan
                                            @can('answer.create')
                                            <a href="{{ route('answers.create') }}" class=" float-end btn btn-xs btn-primary float-end" name="create_new" type="button">
                                                <i class="fa-solid fa-plus"></i> Create Answer
                                            </a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 ">
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
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" colspan="2">Order</th>
                                        <th class="text-nowarap">Status</th>
                                        <th class="text-nowarap">Answer in English</th>
                                        <th class="text-nowarap">Answer in Bangla</th>
                                        <th class="text-nowarap">Question</th>
                                        <th class="text-nowarap">Respondent Type</th>
                                        <!-- <th class="text-nowarap">Created At</th>
                                        <th class="text-nowarap">Updated At</th> -->

                                        <th class="text-nowarap">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" tablename="tbl_a">
                                    @forelse ($answers as $index => $val)
                                    <tr id="{{ $val->id }}">
                                        <td class=''>
                                            <span class="sort bg-red">
                                                <i class="fa-solid fa-up-down-left-right drag-icon"></i>
                                            </span>
                                        </td>
                                        <td>{{ $val->sl_order }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                <span class="badge bg-secondary">Deleted</span>
                                                @else
                                                @can('question.edit')
                                                <input class="form-check-input active_inactive_btn " status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }} table="tbl_a" type="checkbox" id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}" {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap">{{ $val->answare }}</td>
                                        <td class="text-nowrap">{{ $val->answare_bangla }}</td>
                                        <td class="text-nowrap">{{ isset($val->question) ? $val->question->question : '' }}</td>
                                        
                                        <td class="text-nowrap">{{ $val->respondent_type }}</td>
                                        <!-- <td class="text-nowrap">{{ $val->created_at }}</td> -->
                                        <!-- <td class="text-nowrap">{{ $val->updated_at }}</td> -->

                                        <td class="text-nowrap">
                                            @if (request()->get('status') == 'archived')
                                            {{-- restore button --}}
                                            @can('answer.restore')
                                            <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}" onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-{{ $val->id }}" action="{{ route('answers.restore', Crypt::encryptString($val->id)) }}" method="POST" style="display: none">
                                                @method('POST')
                                                @csrf
                                            </form>
                                            @endcan
                                            {{-- force delete button --}}
                                            @can('answer.force_delete')
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }}" onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-{{ $val->id }}" style="display: none" action="{{ route('answers.force-delete', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @else
                                            {{-- edit button --}}
                                            @can('answer.edit')
                                            @if ($val->status == 7)
                                            <a href="{{ route('answers.edit', [Crypt::encryptString($val->id),'page'=> $answers->currentPage()]) }}" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                            @endif
                                            @endcan
                                            {{-- delete button --}}
                                            @can('answer.delete')
                                            <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}" onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-{{ $val->id }}" style="display: none" action="{{ route('answers.destroy', Crypt::encryptString($val->id)) }}" method="POST">
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
                        </div>
                        {{ $answers->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script></script>
    @endpush
</x-app-layout>