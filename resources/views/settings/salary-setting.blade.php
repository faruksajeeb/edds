<x-app-layout>
    <x-slot name="title">
        Salary Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Salary Settings</h3>
                        </div>
                    </div>
                </div>

                <form>

                    <div class="settings-widget">
                        <div class="h3 card-title with-switch">
                            DA and HRA
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_hra"
                                    checked>
                                <label class="onoffswitch-label" for="switch_hra">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>DA (%)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>HRA (%)</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="settings-widget">
                        <div class="h3 card-title with-switch">
                            Provident Fund Settings
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_pf"
                                    checked>
                                <label class="onoffswitch-label" for="switch_pf">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee Share (%)</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Organization Share (%)</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="settings-widget">
                        <div class="h3 card-title with-switch">
                            ESI Settings
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_esi">
                                <label class="onoffswitch-label" for="switch_esi">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee Share (%)</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Organization Share (%)</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="settings-widget">
                        <div class="h3 card-title with-switch">
                            TDS&nbsp; <small class="form-text text-muted">Annual Salary</small>
                            <div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="switch_tds">
                                <label class="onoffswitch-label" for="switch_tds">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Salary From</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Salary To</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>%</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="d-none d-sm-block">&nbsp;</label>
                                    <button class="btn btn-danger w-100 set-btn" type="button"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Salary From</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Salary To</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>%</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="d-none d-sm-block">&nbsp;</label>
                                    <button class="btn btn-danger w-100 set-btn" type="button"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-sm-2 ms-auto">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100" type="button"><i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
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
