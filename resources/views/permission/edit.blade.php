@push('styles')
    <style>
        ul {
            list-style: none;
            font-size: 17px;
        }

        input.largerCheckbox {
            width: 17px;
            height: 17px;
        }

        label {}
    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Edit Permission
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title py-1"><i class="fa fa-pencil"></i> Edit Permission</h4>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('permissions') }}">Permission</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', Crypt::encryptString($permissionInfo->id)) }}"
                        method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for=""
                                class="@if ($errors->has('group_name')) has-error @endif fw-bold">Permission
                                Group *</label><br />
                            <select name="group_name" id="group_name"
                                class="form-select  @error('group_name') is-invalid @enderror">
                                <option value="">--select permission group--</option>
                                @foreach ($permission_groups as $val)
                                    <option value="{{ $val->name }}" {{ ($val->name == old('group_name', $permissionInfo->group_name))? 'selected':'';}}>{{ $val->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for=""
                                class="@if ($errors->has('name')) has-error @endif fw-bold">Permission
                                Name *</label><br />
                            <input type="text" name='name' id='name' value="{{ old('name', $permissionInfo->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter permission name">
                        </div>
                        <div class="form-group">
                            <label for="" class="@if ($errors->has('is_menu')) has-error @endif fw-bold">Is
                                Menu?</label><br />
                            <select name="is_menu" id="is_menu"
                                class="form-select  @error('is_menu') is-invalid @enderror">
                                <option value="no" {{ old('is_menu',$permissionInfo->is_menu) == 'no' ? 'selected' : '' }}>No</option>
                                <option value="yes" {{ old('is_menu',$permissionInfo->is_menu) == 'yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <section id="menu_section" style="display: none">
                            <div class="form-group">
                                <label for=""
                                    class="@if ($errors->has('menu_name')) has-error @endif fw-bold">Menu
                                    Name</label><br />
                                <input type="text" name='menu_name' id='menu_name' value="{{ old('menu_name',$permissionInfo->menu_name) }}"
                                    class="form-control @error('menu_name') is-invalid @enderror"
                                    placeholder="If is menu? Yes. Please enter menu name">
                            </div>
                            <div class="form-group">
                                <label for=""
                                    class="@if ($errors->has('icon')) has-error @endif fw-bold">Menu
                                    Icon</label><br />
                                <input type="text" name='icon' id='icon' value="{{ old('icon',$permissionInfo->icon) }}"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    placeholder="Enter font awesome icon">
                            </div>
                        </section>

                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit-btn" class="btn btn-success btn-lg btn-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $(function() {
                    $('#menu_section').hide();
                    let isMenu = $('#is_menu').val();
                    menuSectionShowHide(isMenu);
                    $('#is_menu').on('change', function() {
                        let isMenu = $(this).val();
                        menuSectionShowHide(isMenu);
                        $('#name').val(groupName + '.');
                    });
                    $('#group_name').on('change', function() {
                        let groupName = $(this).val();
                        $('#name').val(groupName + '.');
                    });
                });
                menuSectionShowHide = (isMenu) => {
                    if (isMenu === 'yes') {
                        $('#menu_section').show();
                    } else {
                        $('#menu_section').hide();
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
