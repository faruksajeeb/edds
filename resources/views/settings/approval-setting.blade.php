<x-app-layout>
    <x-slot name="title">
        Approval Settings
    </x-slot>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Approval Settings</h3>
                        </div>
                    </div>
                </div>

                <form>
                    <ul class="nav nav-tabs nav-tabs-bottom" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">
                                Expenses Approval
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Leave Approval</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="messages-tab" data-bs-toggle="tab" href="#messages" role="tab"
                                aria-controls="messages" aria-selected="false">Offer Approval</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="settings-tab" data-bs-toggle="tab" href="#settings" role="tab"
                                aria-controls="settings" aria-selected="false">Resignation Notice</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <h4>Expense Approval Settings</h4>
                            <div class="form-group row">
                                <label class="control-label col-md-12">Default Expense Approval</label>
                                <div class="col-md-12 approval-option">
                                    <label class="radio-inline">
                                        <input id="radio-single1" class="me-2 default_expense_approval"
                                            value="seq-approver" checked="" name="default_expense_approval"
                                            type="radio">Sequence Approval (Chain) <sup> <span
                                                class="badge info-badge"><i class="fa fa-info"
                                                    aria-hidden="true"></i></span></sup>
                                    </label>
                                    <label class="radio-inline ms-2">
                                        <input id="radio-multiple3" class="me-2 default_expense_approval"
                                            value="sim-approver" name="default_expense_approval"
                                            type="radio">Simultaneous Approval <sup><span class="badge info-badge"><i
                                                    class="fa fa-info" aria-hidden="true"></i></span></sup>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group  form-row row approver seq-approver" style="display: block;">
                                <label class="control-label col-sm-3">Expense Approvers</label>
                                <div class="col-sm-9 ">
                                    <label class="ex_exp_approvers_1 control-label mb-2 exp_appr"
                                        style="padding-left:0">Approver 1</label>
                                    <div class="row ex_exp_approvers_1 form-group">
                                        <div class="col-md-6">
                                            <select class="select form-control expense_approvers" style="width:260px"
                                                name="expense_approvers[]" tabindex="-1" aria-hidden="true">
                                                <option value="">Select Approvers</option>
                                                <option value="1">CEO</option>
                                                <option value="9">Direct Manager</option>
                                                <option value="11">Development Manager
                                                </option>
                                                <option value="6">Finance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="ex_exp_approvers_2 control-label mb-2 exp_appr"
                                        style="padding-left:0">Approver 2</label>
                                    <div class="row ex_exp_approvers_2 form-group">
                                        <div class="col-md-6">
                                            <select class="select form-control expense_approvers " style="width:260px"
                                                name="expense_approvers[]" tabindex="-1" aria-hidden="true">
                                                <option value="">Select Approvers</option>
                                                <option value="1">CEO</option>
                                                <option value="9">Direct Manager</option>
                                                <option value="11">Development Manager
                                                </option>
                                                <option value="6">Finance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"><a
                                                class="remove_ex_exp_approver btn rounded border text-danger"
                                                data-id="2"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <label class="ex_exp_approvers_3 control-label m-b-10 exp_appr"
                                        style="padding-left:0">Approver 3</label>
                                    <div class="row ex_exp_approvers_3 form-group">
                                        <div class="col-md-6">
                                            <select class="select form-control expense_approvers" style="width:260px"
                                                name="expense_approvers[]" tabindex="-1" aria-hidden="true">
                                                <option value="">Select Approvers</option>
                                                <option value="1">CEO</option>
                                                <option value="9">Direct Manager</option>
                                                <option value="11">Development Manager
                                                </option>
                                                <option value="6">Finance</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2"><a
                                                class="remove_ex_exp_approver btn rounded border text-danger"
                                                data-id="3"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9 col-md-offset-3 m-t-10">
                                        <a id="add_expense_approvers" href="javascript:void(0)" class="add-more">+
                                            Add Approver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group row">
                                <label class="control-label col-md-12">Default Leave Approval</label>
                                <div class="col-md-12 approval-option">
                                    <label class="radio-inline">
                                        <input id="radio-single" class="me-2 default_offer_approval"
                                            value="seq-approver" name="default_leave_approval"
                                            type="radio">Sequence Approval (Chain) <sup> <span
                                                class="badge info-badge"><i class="fa fa-info"
                                                    aria-hidden="true"></i></span></sup>
                                    </label>
                                    <label class="radio-inline ms-2">
                                        <input id="radio-multiple1" class="me-2 default_offer_approval"
                                            value="sim-approver" checked="" name="default_leave_approval"
                                            type="radio">Simultaneous Approval <sup><span
                                                class="badge info-badge"><i class="fa fa-info"
                                                    aria-hidden="true"></i></span></sup>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-12">leave Approvers</label>
                                <div class="col-sm-6">
                                    <label class="control-label"
                                        style="margin-bottom:10px;padding-left:0">Simultaneous Approval </label>
                                    <select class="select form-control" multiple>
                                        <option>Select</option>
                                        <option>Test Lead</option>
                                        <option>UI/UX Designer</option>
                                        <option>Sox Analyst</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                            <form>
                                <h4>Offer Approval Settings</h4>
                                <div class="form-group">
                                    <label class="control-label col-md-12">Default Offer Approval</label>
                                    <div class="col-md-12 approval-option">
                                        <label class="radio-inline">
                                            <input id="radio-single2" class="me-2 default_offer_approval"
                                                value="seq-approver" name="default_offer_approval"
                                                type="radio">Sequence Approval (Chain) <sup> <span
                                                    class="badge info-badge"><i class="fa fa-info"
                                                        aria-hidden="true"></i></span></sup>
                                        </label>
                                        <label class="radio-inline ms-2">
                                            <input id="radio-multiple2" class="me-2 default_offer_approval"
                                                value="sim-approver" checked="" name="default_offer_approval"
                                                type="radio">Simultaneous Approval <sup><span
                                                    class="badge info-badge"><i class="fa fa-info"
                                                        aria-hidden="true"></i></span></sup>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form>
                                <h3>Resignation Notice</h3>
                                <div class="form-group row">
                                    <label class="col-sm-12">Email Notification <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <label class="control-label">Simultaneous Approval </label>
                                        <select class="select form-control" multiple>
                                            <option>Select</option>
                                            <option>Test Lead</option>
                                            <option>UI/UX Designer</option>
                                            <option>Sox Analyst</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-12">Notice Days <span class="text-danger">*</span></label>
                                    <div class="col-md-6 approval-option">
                                        <input type="number" name="notice_days" class="form-control notice_days"
                                            value="15">
                                    </div>
                                </div>
                            </form>
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
