<x-app-layout>
    <x-slot name="title">
        Change Password
    </x-slot>
    @push('styles')
        <style>

        </style>
    @endpush
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-4 offset-md-4">

                <div class="page-header py-3 my-3">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h3 class="page-title">Change Password</h3>
                        </div>
                    </div>
                </div>
                <form action="{{ route('change-password') }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Old Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                            name="old_password" value="{{old('old_password')}}">
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password"  value="{{ old('new_password') }}">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="new_password_confirmation" value="">
                    </div>

                    <br>
                    <div class="submit-section">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button class="btn btn-lg btn-outline-secondary submit-btn rounded-pill">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
