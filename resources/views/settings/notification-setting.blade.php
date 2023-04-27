<x-app-layout>
    <x-slot name="title">
        Notification Settings
    </x-slot>
    @push('styles')
        <style>
            .status-toggle {
                float: right;
            }

            .status-toggle .check {
                display: block;
                height: 0;
                visibility: hidden;
                opacity: 0;
                pointer-events: none;
                position: absolute;
                margin: 0;
                padding: 0;
            }

            .status-toggle .check:checked+.checktoggle {
                background-color: #55ce63;
            }

            .status-toggle .check:checked+.checktoggle:after {
                left: 100%;
                transform: translate(calc(-100% - 5px), -50%);
            }

            .status-toggle .checktoggle {
                background-color: #e0001a;
                cursor: pointer;
                display: block;
                font-size: 0;
                height: 24px;
                margin-bottom: 0;
                position: relative;
                width: 48px;
                border-radius: 12px;
            }

            .status-toggle .checktoggle:after {
                content: " ";
                display: block;
                width: 16px;
                height: 16px;
                background-color: #ffffff;
                -webkit-transition: all 0.2s ease;
                -ms-transition: all 0.2s ease;
                transition: all 0.2s ease;
                transform: translate(5px, -50%);
                -webkit-transform: translate(5px, -50%);
                -ms-transform: translate(5px, -50%);
                position: absolute;
                top: 50%;
                left: 0;
                border-radius: 50%;
            }
        </style>
    @endpush
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Notifications Settings</h3>
                        </div>
                    </div>
                </div>

                <form>
                    <div>
                        <ul class="list-group notification-list">
                            <li class="list-group-item">
                                Employee
                                <div class="status-toggle">
                                    <input type="checkbox" id="staff_module" class="check">
                                    <label for="staff_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Holidays
                                <div class="status-toggle">
                                    <input type="checkbox" id="holidays_module" class="check" checked>
                                    <label for="holidays_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Leaves
                                <div class="status-toggle">
                                    <input type="checkbox" id="leave_module" class="check" checked>
                                    <label for="leave_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Events
                                <div class="status-toggle">
                                    <input type="checkbox" id="events_module" class="check" checked>
                                    <label for="events_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Chat
                                <div class="status-toggle">
                                    <input type="checkbox" id="chat_module" class="check" checked>
                                    <label for="chat_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Jobs
                                <div class="status-toggle">
                                    <input type="checkbox" id="job_module" class="check">
                                    <label for="job_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>
                        </ul>
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
