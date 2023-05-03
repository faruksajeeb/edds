<x-app-layout>
    <x-slot name="title">
        Survey Report
    </x-slot>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Survey Report</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <label for="Division" class="col-sm-3 col-form-label">Division</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select division--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="district" class="col-sm-3 col-form-label">DIstrict</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select district--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Thana</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select thana--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select area--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Market</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select market--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select category--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="thana" class="col-sm-3 col-form-label">Subcategory</label>
                            <div class="col-sm-9">
                                <select name="" id="" class="form-select">
                                    <option value="">--select subcategory--</option>
                                    <option value="dhaka">Dhaka</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="ate from" class="col-sm-3 col-form-label">Date From</label>
                            <div class="col-sm-9">
                                <input type="text" class="datepicker form-control" name="date_from"/>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="date to" class="col-sm-3 col-form-label">Date To</label>
                            <div class="col-sm-9">
                                <input type="text" class="datepicker form-control" name="date_from"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-lg btn-secondary">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
