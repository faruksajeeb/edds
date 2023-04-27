<x-app-layout>
    <x-slot name="title">
        Basic Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Basic Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="{{ route('basic-setting') }}" method="POST" class="needs-validation" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Default Country</label>
                                <select name="default_country" class="select form-control  @error('default_country') is-invalid @enderror">
                                    <option value="Bangladesh" {{ ($basicSettings && ($basicSettings->default_country == 'Bangladesh') ) ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="India" {{ ($basicSettings && ($basicSettings->default_country == 'India') ) ? 'selected' : '' }}>India</option>
                                    <option value="Pakisthan" {{ ($basicSettings && ($basicSettings->default_country == 'Pakisthan') ) ? 'selected' : '' }}>Pakisthan</option>
                                    <option value="Miyanmar" {{ ($basicSettings && ($basicSettings->default_country == 'Miyanmar') ) ? 'selected' : '' }}>Miyanmar</option>
                                    <option value="Nepal" {{ ($basicSettings && ($basicSettings->default_country == 'Nepal') ) ? 'selected' : '' }}>Nepal</option>
                                    <option value="Bhutan" {{ ($basicSettings && ($basicSettings->default_country == 'Bhutan') ) ? 'selected' : '' }}>Bhutan</option>
                                    <option value="Srilanka" {{ ($basicSettings && ($basicSettings->default_country == 'Srilanka') ) ? 'selected' : '' }}>Srilanka</option>
                                </select>
                                @error('default_country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date Format</label>
                                <select name="date_format" class="select form-control  @error('date_format') is-invalid @enderror">                                    
                                    <option value="Y-m-d" {{ ($basicSettings && ($basicSettings->date_format == 'Y-m-d') ) ? 'selected' : '' }}>2016-05-15</option>
                                    <option value="d/m/Y" {{ ($basicSettings && ($basicSettings->date_format == 'd/m/Y') ) ? 'selected' : '' }}>15/05/2016</option>
                                    <option value="d.m.Y" {{ ($basicSettings && ($basicSettings->date_format == 'd.m.Y') ) ? 'selected' : '' }}>15.05.2016</option>
                                    <option value="d-m-Y" {{ ($basicSettings && ($basicSettings->date_format == 'd-m-Y') ) ? 'selected' : '' }}>15-05-2016</option>
                                    <option value="m/d/Y" {{ ($basicSettings && ($basicSettings->date_format == 'm/d/Y') ) ? 'selected' : '' }}>05/15/2016</option>
                                    <option value="Y/m/d" {{ ($basicSettings && ($basicSettings->date_format == 'Y/m/d') ) ? 'selected' : '' }}>2016/05/15</option>
                                    <option value="M d Y" {{ ($basicSettings && ($basicSettings->date_format == 'M d Y') ) ? 'selected' : '' }}>May 15 2016</option>
                                    <option value="d M Y" {{ ($basicSettings && ($basicSettings->date_format == 'd M Y') ) ? 'selected' : '' }}>15 May 2016</option>
                                </select>
                                @error('date_format')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Timezone</label>
                                <select name="timezone" class="select form-control  @error('timezone') is-invalid @enderror">
                                    <option value="Asia/Dhaka" {{ ($basicSettings && ($basicSettings->timezone == 'Asia/Dhaka') ) ? 'selected' : '' }}>(UTC +6:00) Asia/Dhaka</option>
                                    <option value="America/New_York" {{ ($basicSettings && ($basicSettings->timezone == 'America/New_York') ) ? 'selected' : '' }}>(UTC -5:00) America/New_York</option>
                                </select>
                                @error('timezone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Default Language</label>
                                <select name="default_language" class="select form-control  @error('default_language') is-invalid @enderror">
                                    <option value="English" {{ ($basicSettings && ($basicSettings->default_language == 'English') ) ? 'selected' : '' }}>English</option>
                                    <option value="Bangla" {{ ($basicSettings && ($basicSettings->default_language == 'Bangla') ) ? 'selected' : '' }}>Bangla</option>
                                    <option value="French" {{ ($basicSettings && ($basicSettings->default_language == 'French') ) ? 'selected' : '' }}>French</option>
                                </select>
                                @error('default_language')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Currency Code</label>
                                <select name="currency_code" class="select form-control  @error('currency_code') is-invalid @enderror">
                                    <option value="BDT" {{ ($basicSettings && ($basicSettings->currency_code == 'BDT') ) ? 'selected' : '' }}>BDT</option>
                                    <option value="USD" {{ ($basicSettings && ($basicSettings->currency_code == 'USD') ) ? 'selected' : '' }}>USD</option>
                                    <option value="Pound" {{ ($basicSettings && ($basicSettings->currency_code == 'Pound') ) ? 'selected' : '' }}>Pound</option>
                                    <option value="EURO" {{ ($basicSettings && ($basicSettings->currency_code == 'EURO') ) ? 'selected' : '' }}>EURO</option>
                                    <option value="Ringgit" {{ ($basicSettings && ($basicSettings->currency_code == 'Ringgit') ) ? 'selected' : '' }}>Ringgit</option>
                                </select>
                                @error('currency_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Currency Symbol</label>
                                <select name="currency_symbol" class="select form-control  @error('currency_symbol') is-invalid @enderror">
                                    <option value="৳" {{ ($basicSettings && ($basicSettings->currency_symbol == '৳') ) ? 'selected' : '' }}>৳</option>
                                    <option value="$" {{ ($basicSettings && ($basicSettings->currency_symbol == '$') ) ? 'selected' : '' }}>$</option>
                                    <option value="£" {{ ($basicSettings && ($basicSettings->currency_symbol == '£') ) ? 'selected' : '' }}>£</option>
                                    <option value="€" {{ ($basicSettings && ($basicSettings->currency_symbol == '€') ) ? 'selected' : '' }}>€</option>
                                    <option value="RM" {{ ($basicSettings && ($basicSettings->currency_symbol == 'RM') ) ? 'selected' : '' }}>RM</option>
                                </select>
                                @error('currency_symbol')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
