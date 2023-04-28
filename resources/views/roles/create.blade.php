@push('styles')
    <style>
        ul {
            list-style: none;
            font-size: 20px;
        }

        input.largerCheckbox {
            width: 20px;
            height: 20px;
        }

        label {}
    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Role
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Create Role</h3>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('roles') }}">Role</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for=""
                                class="@if ($errors->has('name')) has-error @endif fw-bold">Role
                                Name</label><br />
                            <input type="text" name='name' value="{{ old('name') }}"
                                class="form-control-lg @error('name') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label for="" class="fw-bolder">Role Permissions</label>
                            <br>
                            <label class="checkbox select-all-permission">
                                <input type="checkbox" name="permission_all" id="permission_all" class="largerCheckbox">
                                All
                            </label>

                            <div class="row row-cols-1 row-cols-md-4 gx-4 m-1">
                                @foreach ($permission_groups as $groupIndex => $permission_group)
                                    <div class="col themed-grid-col text-start">
                                        <label for="permission_group{{ $groupIndex }}"
                                            class="checkbox group-permission fw-bold {{ $permission_group->group_name }}"
                                            onclick="checkPermissionByGroup('{{ $permission_group->group_name }}')">
                                            <input type="checkbox" class="group largerCheckbox" name="group-permission[]">
                                            {{ ucfirst($permission_group->group_name) }}

                                        </label>

                                        <hr>
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
                                                        <input type="checkbox" value="{{ $permission->name }}" class="largerCheckbox"
                                                            name="permissions[]" id="permission{{ $permission->id }}">
                                                        {{ ucwords(str_replace('.', ' ', $permission->name)) }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>

          
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-lg btn-success ">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {

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
