<x-app-layout>
    <x-slot name="title">
        healthcares
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
                                @endif Healthcares
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                        Deleted
                                        @endif healthcares
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                            <a href="{{ url('/healthcares?status=archived') }}">Deleted healthcares</a>
                            @else
                            <a href="{{ url('/healthcares') }}">healthcares</a>
                            @endif
                            @if (request()->get('status') == 'archived' && $healthcares->total() > 0)
                            @can('healthcare.restore')
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="{{ route('healthcares.restore-all') }}" style="display:inline" method="POST">
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
                                    <select name="search_center_type" class="form-select" id="search_center_type">
                                        <option value="">Select Center Type</option>
                                        <option value="human" {{ request()->get('search_center_type') == 'human' ? 'selected' : '' }}>Human
                                        <option value="animal" {{ request()->get('search_center_type') == 'animal' ? 'selected' : '' }}>Animal
                                      
                                    </select>
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7" {{ request()->get('search_status') == 7 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="-7" {{ request()->get('search_status') == -7 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <input type="text" name="search_text" value="{{ request()->get('search_text') }}" class="form-control" placeholder="Search by text">
                                </div>
                                <div class="col-md-12 col-sm-12 px-0 mt-1 input-group">
                                    <button class="btn btn-secondary me-1 filter_btn" name="submit_btn" type="submit" value="search">
                                        <i class="fa fa-search"></i> Filter Data
                                    </button>
                                    <a href='{{ request()->get('status') == 'archived' ? url('/healthcares?status=archived') : url()->current() }}' class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i>
                                        Refresh</a>
                                    @can('healthcare.export')
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
                                    @can('healthcare.import')
                                    <a href="{{ route('healthcares.import') }}" class="btn btn-xs btn-info float-end" name="create_new" type="button">
                                        <i class="fa-solid fa-upload"></i> Import
                                    </a>
                                    @endcan
                                    @can('healthcare.create')
                                    <a href="{{ route('healthcares.create') }}" class="btn btn-xs btn-outline-primary float-end" name="create_new" type="button">
                                        <i class="fa-solid fa-plus"></i> Create healthcare
                                    </a>
                                    @endcan
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Status</th>
                                        <th>Center Type</th>
                                        <th>healthcare In English</th>
                                        <th>healthcare In Bangla</th>
                                        <th>Latitude </th>
                                        <th>Longitude </th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($healthcares as $index => $val)
                                    <tr>
                                        <td>{{ $index + $healthcares->firstItem() }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                <span class="badge bg-secondary">Archived</span>
                                                @else
                                                @can('healthcare.edit')
                                                <input class="form-check-input active_inactive_btn " status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }} table="tbl_healthcare" type="checkbox" id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}" {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $val->type }}</td>
                                        <td class="text-nowrap">{{ $val->hospital_name_english }}</td>
                                        <td class="text-nowrap">{{ $val->hospital_name_bangla }}</td>
                                        <td class="text-nowrap">{{ $val->latitude }}</td>
                                        <td class="text-nowrap">{{ $val->longitude }}</td>

                                        <td class="text-nowrap">
                                            @if (request()->get('status') == 'archived')
                                            {{-- restore button --}}
                                            @can('healthcare.restore')
                                            <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}" onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-{{ $val->id }}" action="{{ route('healthcares.restore', Crypt::encryptString($val->id)) }}" method="POST" style="display: none">
                                                @method('POST')
                                                @csrf
                                            </form>
                                            @endcan
                                            {{-- force delete button --}}
                                            @can('healthcare.force_delete')
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }} disabled" onclick="event.preventDefault(); forceDelete({{ $val->id }})" disabled><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-{{ $val->id }}" style="display: none" action="{{ route('healthcares.force-delete', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @else
                                            {{-- edit button --}}
                                            @can('healthcare.edit')
                                            @if ($val->status == 7)
                                            <a href="{{ route('healthcares.edit', Crypt::encryptString($val->id)) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            @endif
                                            @endcan
                                            {{-- delete button --}}
                                            @can('healthcare.delete')
                                            <a href="" class="btn btn-danger btn-sm btn-delete-{{ $val->id }}" onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-{{ $val->id }}" style="display: none" action="{{ route('healthcares.destroy', Crypt::encryptString($val->id)) }}" method="POST">
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
                        {{ $healthcares->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script></script>
    @endpush
</x-app-layout>