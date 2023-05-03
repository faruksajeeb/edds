<x-app-layout>
    <x-slot name="title">
        Users
    </x-slot>
    @php
        $loggedUser = Auth::guard('web')->user();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-list"></i> Users</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Users</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            @csrf
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
                                <div class="col-md-6 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                            @if ($loggedUser && $loggedUser->can('user.export'))
                                                <button class="btn btn-xs btn-success float-end" name="submit_btn"
                                                    value="export" type="submit">
                                                    <i class="fa-solid fa-download"></i> Export
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    @if ($loggedUser && $loggedUser->can('user.create'))
                                        <a href="{{ route('users.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create New
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </form>
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Permissions</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->email }}</td>
                                        <td>
                                            @foreach ($val->roles as $role)
                                                <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                                {{-- <br /> --}}
                                            @endforeach

                                        </td>
                                        <td width="30%">
                                            * User can access assigned role permissions. <br />
                                            @if (count($val->permissions) > 0)
                                                and also access below permissions too.
                                                @foreach ($val->permissions as $permission)
                                                    <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                                                    {{-- <br /> --}}
                                                @endforeach
                                                <br />
                                            @endif
                                        </td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td>
                                        <td>

                                            @if ($loggedUser && $loggedUser->can('user.edit'))
                                                <a href="{{ route('users.edit', Crypt::encryptString($val->id)) }}"
                                                    class="btn btn-outline-warning"><i
                                                        class="fa-solid fa-pencil"></i></a>
                                            @endif

                                            @if ($loggedUser && $loggedUser->can('user.delete'))
                                                <a href="" class="btn btn-outline-danger"
                                                    onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                                        class="fa-solid fa-remove"></i></a>
                                                <form id="delete-form-{{ $val->id }}"
                                                    action="{{ route('users.destroy', Crypt::encryptString($val->id)) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
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
