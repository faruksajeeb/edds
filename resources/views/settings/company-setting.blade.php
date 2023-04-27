<x-app-layout>
    <x-slot name="title">
        Company Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3 my-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Company Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="{{ route('company-setting') }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input name="company_name" class="form-control @error('company_name') is-invalid @enderror" type="text"
                                    value="{{ $companySettings ? $companySettings->company_name : old('company_name') }}" placeholder="Enter company name" required>
                                    <div class="invalid-feedback error_msg company_name_err">Company Name is required!</div>
                                @error('company_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input name="contact_person" class="form-control "
                                    value="{{ (old('contact_person')) ? old('contact_person'):($companySettings ? $companySettings->contact_person : '') }}"
                                    paceholder="Enter contact person" type="text">
                                    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" class="form-control" placeholder="Enter company address"
                                    value="{{ (old('address')) ? old('address'):(($companySettings) ? $companySettings->address :'') }}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Country</label>

                                <input class="form-control" placeholder="Enter country name"
                                    value="{{ (old('country')) ? old('country'):($companySettings ? $companySettings->country : '') }}" type="text">
                                {{-- <select class="form-control select">
                                    <option>USA</option>
                                    <option>United Kingdom</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>City</label>
                                <input name="city" class="form-control" placeholder="Enter city name"
                                    value="{{ (old('city')) ? old('city'):($companySettings ? $companySettings->city : '') }}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>State/Province</label>
                                <input name="state" class="form-control" placeholder="Enter state/province"
                                    value="{{ (old('state')) ? old('state'):($companySettings ? $companySettings->state : '') }}" type="text">

                                {{-- <select class="form-control select">
                                    <option>California</option>
                                    <option>Alaska</option>
                                    <option>Alabama</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input name="postal_code" class="form-control"
                                    value="{{ (old('postal_code')) ? old('postal_code'):($companySettings ? $companySettings->postal_code : '') }}"
                                    type="text" placeholder="Enter posta code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" placeholder="Enter email"
                                    value="{{ (old('email')) ? old('email'):($companySettings ? $companySettings->email : '') }}" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input name="phone_number" class="form-control"
                                    value="{{ (old('phone_number')) ? old('phone_number'):($companySettings ? $companySettings->phone_number : '') }}"
                                    type="text" placeholder="Enter phone number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input name="mobile_number" class="form-control"
                                    value="{{ (old('mobile_number')) ? old('mobile_number'):($companySettings ? $companySettings->mobile_number : '') }}"
                                    type="text" placeholder="Enter mobile number">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fax</label>
                                <input name="fax" class="form-control" placeholder="Enter fax"
                                    value="{{ (old('fax')) ? old('fax'):($companySettings ? $companySettings->fax : '') }}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Website Url</label>
                                <input name="website_url" class="form-control" placeholder="Enter website url"
                                    value="{{ (old('website_url')) ?old('website_url'):($companySettings ? $companySettings->website_url : '') }}"
                                    type="text">
                            </div>
                        </div>
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
