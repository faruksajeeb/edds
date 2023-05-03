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
                            <h3 class="card-title py-1"><i class="fa fa-list"></i> Roles</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Roles</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            <input type="hidden" name="_token" value="B7Tuv4nPCe86gWsjastnnmhS3EQPF2a7rOxWV7IA">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <select name="search_status" class="form-select" id="search_status">
                                        <option value="">Select Status</option>
                                        <option value="7">Active
                                        </option>
                                        <option value="-7">Inactive
                                        </option>
                                        <option value="-1">Deleted
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
                                            <button class="btn btn-xs btn-success float-end" name="submit_btn"
                                                value="export" type="submit">
                                                <i class="fa-solid fa-download"></i> Export
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <a href="{{route('clear-permission-cache')}}" class="btn btn-outline-secondary">Clear Permission Cache</a>
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
                                    <th>Permissions</th>
                                    <th>Guard Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
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
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td>
                                        <td><div class="form-check form-switch">
                                            <input class="form-check-input active_inactive_btn "
                                                status="{{ $val->status }}" {{ $val->status == -1 ? '' : '' }}
                                                table="roles" type="checkbox" id="row_{{ $val->id }}"
                                                value="{{ Crypt::encryptString($val->id) }}"
                                                {{ $val->status == 1 ? 'checked' : '' }} style="cursor:pointer">
                                        </div></td>
                                        <td class="text-nowrap">
                                            @can('role.edit')
                                                <a href="{{ route('roles.edit', Crypt::encryptString($val->id)) }}"
                                                    class="btn btn-outline-warning"><i class="fa-solid fa-pencil"></i></a>
                                            @endcan
                                            @can('role.delete')
                                                <a href="{{ route('roles.destroy', Crypt::encryptString($val->id)) }}"
                                                    class="btn btn-outline-danger"
                                                    onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                                        class="fa-solid fa-remove"></i></a>
                                                <form id="delete-form-{{ $val->id }}"
                                                    action="{{ route('roles.destroy', Crypt::encryptString($val->id)) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        confirmDelete = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
    
            })
        }
    </script>
    @endpush
</x-app-layout>
