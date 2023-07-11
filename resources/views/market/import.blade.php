@push('styles')
    <style>

    </style>
@endpush
<x-app-layout>
    <x-slot name="title">
        Create Market
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title py-1"><i class="fa fa-plus"></i> Import Market</h3>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('markets') }}">Markets</a></li>
                                    <li class="breadcrumb-item " aria-current="page">Import</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('markets.import') }}" method="POST" class="needs-validation"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        {{-- <div class="form-group my-1">
                            <label for=""
                                class="@if ($errors->has('value_bangla')) has-error @endif fw-bold">Area <span class="text-danger">*</span></label>
                            <select name="area_id" id="area_id" class="form-select" required>
                                <option value="">--select area--</option>
                                @foreach ($areas as $val)
                                    <option value="{{ $val->id }}" {{ $val->id==old('area_id')?'selected':''}}>{{ $val->value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('area_id'))
                                @error('area_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select area.
                                </div>
                            @endif
                        </div> --}}

                        <div class="form-group mb-3">
                            <label for="import_file" class="@if ($errors->has('import_file')) has-error @endif fw-bold">
                                Import File <span class="text-danger">*</span></label><br />
                            <input type="file" name='import_file' id='import_file'
                                class="form-control @error('import_file') is-invalid @enderror"
                                placeholder="Enter import_file" value="{{ old('import_file') }}" required>
                            @if ($errors->has('import_file'))
                                @error('import_file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="invalid-feedback">
                                    Please select a valid file.
                                </div>
                                <div class="text-info">
                                    Please must be select a file of type: xls, xlsx, csv.
                                </div>
                            @endif
                        </div>
                        
                        Upload File Format Sample:
                        <table style="font-size:10px" class="table table-sm table-bordered my-0">
                            <tr style="background-color: #176B87; color:white">
                                <td>Area</td>
                                <td>Market_Name_Eng</td>
                                <td>Market_Name_Ban</td>
                                <td>Market_Address</td>
                                <td>Latitude</td>
                                <td>Longitude</td>
                            </tr>
                            <tr>
                                <td>DNCC</td>
                                <td>Panir Tanki Bazar</td>
                                <td>পানির ট্যাংকি বাজার</td>
                                <td>11C, Avenue-5, Mirpur-11</td>
                                <td>23.81464</td>
                                <td>90.37478</td>
                            </tr>
                        </table>
                        <a class="float-end my-0 fst-italic" href="{{asset('uploads/upload_file_format/upload_markets_format.xlsx')}}">Download The Format</a>
                        <br />
                        <div class="form-group">
                            <button type="submit" name="submit_btn"
                                class="btn btn-lg btn-success btn-import">Import</button>
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
        </script>
    @endpush
</x-app-layout>
