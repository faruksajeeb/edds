<x-app-layout>
    <x-slot name="title">
        Roles
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-list"></i> @if (request()->get('status') == 'archived')
                                Archived
                             @endif Roles</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item " aria-current="page">@if (request()->get('status') == 'archived')
                                        Archived
                                   @endif Roles</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                                <a href="{{ url('/roles?status=archived') }}">Archived roles</a>
                            @else
                                <a href="{{ url('/roles') }}">Roles</a>
                            @endif
                            @if ((request()->get('status') == 'archived') && ($roles->total() >0))
                                @can('role.restore')
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="{{ route('roles.restore-all') }}"
                                            style="display:inline" method="POST">
                                            @method('POST')
                                            @csrf
                                        </form>
                                    </div>
                                @endcan
                            @endif
                            <a href="{{ route('clear-permission-cache') }}" class="float-end mx-1">Clear Permission
                                Cache</a>
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
                                        {{-- <option value="-1">Deleted
                                        </option> --}}
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
                                            <a href='{{ request()->get('status') == 'archived' ? url('/roles?status=archived') : url('/roles') }}'
                                                class="btn btn-xs btn-secondary mx-1"><i class="fa fa-refresh"></i></a>
                                            <button class="btn btn-xs btn-success float-end mx-1" name="submit_btn"
                                                value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">

                                    @can('role.create')
                                        <a href="{{ route('roles.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create New
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
                                    <th style="min-width:500px">Permissions</th>
                                    <th>Guard Name</th>
                                    {{-- <th>Created At</th>
                                    <th>Updated At</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td width="30%">
                                            @foreach ($val->permissions as $permission)
                                                <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                                                {{-- <br /> --}}
                                            @endforeach
                                        </td>
                                        <td>{{ $val->guard_name }}</td>
                                        {{-- <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td> --}}
                                        <td class="text-end">
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                    <span class="badge bg-secondary">Archived</span>
                                                @else
                                                    @can('role.edit')
                                                        <input class="form-check-input active_inactive_btn "
                                                            status="{{ $val->status }}"
                                                            {{ $val->status == -1 ? '' : '' }} table="roles"
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
                                @can('role.restore')
                                    <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}"
                                        onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-{{ $val->id }}"
                                        action="{{ route('roles.restore', Crypt::encryptString($val->id)) }}" method="POST"
                                        style="display: none">
                                        @method('POST')
                                        @csrf
                                    </form>
                                @endcan
                                {{-- force delete button --}}
                                @can('role.force_delete')
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('roles.force-delete', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @else
                                {{-- edit button --}}
                                @can('role.edit')
                                    <a href="{{ route('roles.edit', Crypt::encryptString($val->id)) }}"
                                        class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a>
                                @endcan
                                {{-- delete button --}}
                                @can('role.delete')
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('roles.destroy', Crypt::encryptString($val->id)) }}" method="POST">
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
                        {{ $roles->withQueryString()->links() }}
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
