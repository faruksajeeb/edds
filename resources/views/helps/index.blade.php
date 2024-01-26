<x-app-layout>
    <x-slot name="title">
        Helps
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
                                @endif Helps
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                        Deleted
                                        @endif Helps
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                            <a href="{{ url('/helps?status=archived') }}">Deleted Helps</a>
                            @else
                            <a href="{{ url('/helps') }}">helps</a>
                            @endif
                            @if (request()->get('status') == 'archived' && $helps->total() > 0)
                            @can('help.restore')
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="{{ route('helps.restore-all') }}" style="display:inline" method="POST">
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
                                <div class="col-md-12 col-sm-12 px-0 input-group">
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7" {{ request()->get('search_status') == 7 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="-7" {{ request()->get('search_status') == -7 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="{{ request()->get('search_text') }}" class="form-control" placeholder="Search by text">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit" value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='{{ request()->get('status') == 'archived' ? url('/helps?status=archived') : url('/helps') }}' class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                        Refresh</a>
                                    @can('help.export')
                                    {{-- <button class="btn btn-xs btn-danger float-end " name="submit_btn"
                                                value="pdf" type="submit">
                                                <i class="fa-solid fa-download"></i> PDF
                                            </button> --}}
                                    {{-- <button class="btn btn-xs btn-info float-end me-1" name="submit_btn"
                                                    value="csv" type="submit">
                                                    <i class="fa-solid fa-download"></i> CSV
                                                </button> --}}

                                    <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn" value="export" type="submit">
                                        <i class="fa-solid fa-download"></i> Export
                                    </button>
                                    @endcan
                                 
                                    @can('help.create')
                                    <a href="{{ route('helps.create') }}" class="btn btn-xs btn-outline-primary float-end" name="create_new" type="button">
                                        <i class="fa-solid fa-plus"></i> Create help
                                    </a>
                                    @endcan
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 mt-1 input-group">

                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Status</th>
                                        <th>Help In English</th>
                                        <th>Help In Bangla</th>
                                        <th>Page</th>
                                        <th>Question</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($helps as $index => $val)
                                    <tr>
                                        <td>{{ $index + $helps->firstItem() }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                <span class="badge bg-secondary">Archived</span>
                                                @else
                                                @can('help.edit')
                                                <input class="form-check-input active_inactive_btn " status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }} table="tbl_help" type="checkbox" id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}" {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="">{{ $val->help_english }}</td>
                                        <td class="">{{ $val->help_bangla }}</td>
                                        <td class="">{{ $val->page_name }}</td>
                                        <td class="">{{ optional($val->question)->question }}</td>

                                        <td class="text-nowrap">
                                            @if (request()->get('status') == 'archived')
                                            {{-- restore button --}}
                                            @can('help.restore')
                                            <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}" onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-{{ $val->id }}" action="{{ route('helps.restore', Crypt::encryptString($val->id)) }}" method="POST" style="display: none">
                                                @method('POST')
                                                @csrf
                                            </form>
                                            @endcan
                                            {{-- force delete button --}}
                                            @can('help.force_delete')
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }} disabled" onclick="event.preventDefault(); forceDelete({{ $val->id }})" disabled><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-{{ $val->id }}" style="display: none" action="{{ route('helps.force-delete', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @else
                                            {{-- edit button --}}
                                            @can('help.edit')
                                            @if ($val->status == 7)
                                            <a href="{{ route('helps.edit', Crypt::encryptString($val->id)) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            @endif
                                            @endcan
                                            {{-- delete button --}}
                                            @can('help.delete')
                                            <a href="" class="btn btn-danger btn-sm btn-delete-{{ $val->id }}" onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-{{ $val->id }}" style="display: none" action="{{ route('helps.destroy', Crypt::encryptString($val->id)) }}" method="POST">
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
                        {{ $helps->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script></script>
    @endpush
</x-app-layout>