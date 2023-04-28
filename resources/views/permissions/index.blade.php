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
                            <h3 class="card-title py-1"><i class="fa fa-list"></i> Permission List</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Permissions</li>
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
                                            @can('permission.edit')
                                                <a href="{{ route('permissions.edit', Crypt::encryptString($val->id)) }}"
                                                    class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pencil"></i></a>
                                            @endcan
                                            @can('permission.delete')
                                                <a href="{{ route('permissions.destroy', Crypt::encryptString($val->id)) }}"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $val->id }}').submit();"><i
                                                        class="fa-solid fa-remove"></i></a>
                                                <form id="delete-form-{{ $val->id }}"
                                                    action="{{ route('permissions.destroy', Crypt::encryptString($val->id)) }}"
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
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
