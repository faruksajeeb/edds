@push('styles')
    <style>
        ul {
            list-style: none;
            font-size:17px;
        }

        input.largerCheckbox {
            width: 17px;
            height: 17px;
        }
    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit User
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-pencil"></i> Edit User</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('users') }}">Users</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body  p-3">
                    <form action="{{ route('users.update', Crypt::encryptString($user->id)) }}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="row  p-3">
                            <div class="col-md-5 border border-1  p-3">
                                <div class="form-group">
                                    <label for="">User Name</label>
                                    <input type="text" name='name' value="{{ old('name', $user->name) }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">User Email</label>
                                    <input type="text" name='email' value="{{ old('email', $user->email) }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name='password' value="{{old('password')}}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name='password_confirmation' class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="roles">Assign Roles</label>
                                    <select name="roles[]" id="" class="form-control select2" data-placeholder="Select one or more..."  multiple
                                        required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->hasRole($role->id) ? 'selected' : '' }}>{{ ucwords($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="" class="fw-bolder">User Permissions</label>
                                    <br>
                                    <label class="checkbox select-all-permission">
                                        <input type="checkbox" name="permission_all" id="permission_all">
                                        All
                                    </label>

                                    <hr>
                                    @foreach ($permission_groups as $groupIndex => $permission_group)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="permission_group{{ $groupIndex }}"
                                                    class="checkbox group-permission {{ $permission_group->group_name }}"
                                                    onclick="checkPermissionByGroup('{{ $permission_group->group_name }}')">
                                                    <input type="checkbox" class="group" name="group-permission[]">
                                                    {{ ucfirst($permission_group->group_name) }}

                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                @php
                                                    $groupWisePermissions = \DB::table('permissions')
                                                        ->where('group_name', $permission_group->group_name)
                                                        ->get();
                                                @endphp
                                                <ul>
                                                    @php
                                                        $permissinCount = count($groupWisePermissions);
                                                    @endphp
                                                    @foreach ($groupWisePermissions as $index => $permission)
                                                        <li
                                                            class="@php echo ($index+1<$permissinCount) ? 'border-bottom':'' @endphp  p-2">
                                                            <label
                                                                class="checkbox single-permission per-{{ $permission_group->group_name }}"
                                                                onclick="checkUncheckModuleByPermission('per-{{ $permission_group->group_name }}', '{{ $permission_group->group_name }}', {{ count($groupWisePermissions) }})">
                                                                <input type="checkbox" value="{{ $permission->name }}"
                                                                    name="permissions[]"
                                                                    id="permission{{ $permission->id }}"  {{ ($user->hasPermissionTo($permission->name)? 'checked':'')}}>
                                                                {{ ucwords(str_replace('.', ' ', $permission->name)) }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </div>
                                        @php echo ($groupIndex+1<count($permission_groups)) ? '<hr>':'' @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-success btn-submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                allChecked();
            });
            $('.select-all-permission input').on('click', function() {
                if ($(this).is(':checked')) {
                    $(".group-permission input").prop("checked", true);
                    $(".single-permission input").prop("checked", true);
                } else {
                    $(".group-permission input").prop("checked", false);
                    $(".single-permission input").prop("checked", false);
                }
            });

            function checkPermissionByGroup(groupName) {

                const singleCheckBox = $('.per-' + groupName + " input");
                if ($('.' + groupName + " input").is(':checked')) {

                    singleCheckBox.prop("checked", true);
                } else {

                    singleCheckBox.prop("checked", false);
                }
                allChecked();
            }

            function checkUncheckModuleByPermission(permissionClassName, GroupClassName, countTotalPermission) {
                const groupIdCheckBox = $('.' + GroupClassName + " input");
                if ($('.' + permissionClassName + " input:checked").length == countTotalPermission) {
                    groupIdCheckBox.prop("checked", true);
                } else {
                    groupIdCheckBox.prop("checked", false);
                }
                allChecked();
            }

            function allChecked() {
                const countTotalPermission = {{ count($permissions) }}
                //alert($(".permission input:checked").length);
                if ($(".single-permission input:checked").length == countTotalPermission) {
                    $('.select-all-permission input').prop("checked", true);
                } else {
                    $('.select-all-permission input').prop("checked", false);
                }
            }
        </script>
    @endpush
</x-app-layout>
