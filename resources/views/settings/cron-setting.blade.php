<x-app-layout>
    <x-slot name="title">
        Cron Settings
    </x-slot>
    @push('styles')
        <style>
            .switch {
                cursor: pointer;
                position: relative;
            }

            .switch input {
                position: absolute;
                opacity: 0;
                filter: alpha(opacity=0);
            }

            .switch input:checked+span {
                background-color: #55ce63;
            }

            .switch input:checked+span:after {
                left: 31px;
            }

            .switch span {
                position: relative;
                width: 60px;
                height: 30px;
                background-color: #ffffff;
                border: 1px solid #eeeeee;
                border-color: rgba(0, 0, 0, 0.1);
                display: inline-block;
                -webkit-transition: all 0.2s ease;
                -ms-transition: all 0.2s ease;
                transition: all 0.2s ease;
                border-radius: 30px;
            }

            .switch span:after {
                content: "";
                background-color: #ffffff;
                width: 26px;
                -webkit-box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
                -moz-box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
                box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
                position: absolute;
                top: 1px;
                bottom: 1px;
                border-radius: 30px;
                -webkit-transition: all 0.2s ease;
                -ms-transition: all 0.2s ease;
                transition: all 0.2s ease;
            }
        </style>
    @endpush
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Cron Settings</h3>
                        </div>
                    </div>
                </div>

                <form>
                    <div class="form-group">
                        <label>Cron Key <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Auto Backup Database <span class="text-danger">*</span></label><br>
                        <label class="switch">
                            <input type="hidden" value="off" name="auto_backup_db">
                            <input type="checkbox" checked="checked" name="auto_backup_db">
                            <span></span>
                        </label>
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
