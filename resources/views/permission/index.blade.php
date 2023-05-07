<x-app-layout>
    <x-slot name="title">
        Permissions
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-list"></i>
                                @if (request()->get('status') == 'archived')
                                    Archived
                                @endif Permissions
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                            Archived
                                        @endif Permissions
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                                <a href="{{ url('/permissions?status=archived') }}">Archived permissions</a>
                            @else
                                <a href="{{ url('/permissions') }}">Permissions</a>
                            @endif
                            @if (request()->get('status') == 'archived')
                                @can('user.restore')
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="{{ route('permissions.restore-all') }}"
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
                                <div class="col-md-5 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            <a href='{{ request()->get('status') == 'archived' ? url('/permissions?status=archived') : url('/permissions') }}'
                                                class="btn btn-xs btn-secondary mx-1"><i class="fa fa-refresh"></i></a>
                                            <button class="btn btn-xs btn-success float-end" name="submit_btn"
                                                value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    @can('permission.create')
                                        <a href="{{ route('permissions.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Permission
                                        </a>
                                    @endcan
                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Name</th>
                                    <th>Group Name</th>
                                    <th>Guard Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $index => $val)
                                    <tr>
                                        <td>{{ $index + $permissions->firstItem() }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->group_name }}</td>
                                        <td>{{ $val->guard_name }}</td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                    <span class="badge bg-secondary">Archived</span>
                                                @else
                                                    @can('permission.edit')
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="{{ $val->status }}"
                                                            {{ $val->status == -1 ? '' : '' }} table="permissions"
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
                                @can('permission.restore')
                                    <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}"
                                        onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-{{ $val->id }}"
                                        action="{{ route('permissions.restore', Crypt::encryptString($val->id)) }}" method="POST"
                                        style="display: none">
                                        @method('POST')
                                        @csrf
                                    </form>
                                @endcan
                                {{-- force delete button --}}
                                @can('permission.force_delete')
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('permissions.force-delete', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @else
                                {{-- edit button --}}
                                @can('permission.edit')
                                    <a href="{{ route('permissions.edit', Crypt::encryptString($val->id)) }}"
                                        class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                @endcan
                                {{-- delete button --}}
                                @can('permission.delete')
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('permissions.destroy', Crypt::encryptString($val->id)) }}" method="POST">
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
                        {{ $permissions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>

        @push('scripts')
            <script>
               
            </script>
        @endpush
    </x-app-layout>
