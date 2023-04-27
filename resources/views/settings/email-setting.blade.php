<x-app-layout>
    <x-slot name="title">
        Email Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Email Settings</h3>
                        </div>
                    </div>
                </div>

                <form>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mailoption" id="phpmail"
                                value="option1">
                            <label class="form-check-label" for="phpmail">PHP Mail</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="mailoption" id="smtpmail"
                                value="option2">
                            <label class="form-check-label" for="smtpmail">SMTP</label>
                        </div>
                    </div>
                    <h4 class="page-title">PHP Email Settings</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email From Address</label>
                                <input class="form-control" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Emails From Name</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <h4 class="page-title m-t-30">SMTP Email Settings</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP HOST</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP USER</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP PASSWORD</label>
                                <input class="form-control" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP PORT</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP Security</label>
                                <select class="select form-control">
                                    <option>None</option>
                                    <option>SSL</option>
                                    <option>TLS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP Authentication Domain</label>
                                <input class="form-control" type="text">
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
