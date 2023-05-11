<section id="sidebar">
    <div class="navigation bg-white">
        <div class="row brand-name-section">
            <div class="col-md-12">
                <ul class="p-0 brand-name">
                    <li class="">
                        <a href="{{ route('dashboard') }}" class="bg-white ">
                            <span class="icon">icddr,b</span>
                            <span class="title">
                                <h5 class=" py-4">{{ $company_settings->company_name }}</h5>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="side-menu h-100 ">
            <ul class="p-0 mb-3" id="menu">
                @if (Auth::guard('web')->user()->can('option_group.view') ||
                        Auth::guard('web')->user()->can('option.view'))
                    <li>
                        <a href="#master_submenu1" data-bs-toggle="collapse" class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fa-solid fa-list"></i></span>
                            <span class="ms-1 d-sm-inline title ">Master</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('users.index') || Route::is('users.create') || Route::is('roles.index') || Route::is('roles.create') ? 'show' : '' }}"
                            id="master_submenu1" data-bs-parent="#menu">
                            <li class="{{ Route::is('option-groups') ? 'active' : '' }}">
                                <a href="{{ url('option-groups') }}" class="nav-link px-2"> <span class="d-sm-inline"><i
                                            class="fa-solid fa-table"></i> Option Groups</span></a>
                            </li>
                            <li class="{{ Route::is('options') ? 'active' : '' }}">
                                <a href="{{ url('options') }}" class="nav-link px-2"> <span class="d-sm-inline"><i
                                            class="fa-solid fa-table"></i> Options</span></a>
                            </li>
                            <li class="{{ Route::is('categories') ? 'active' : '' }}">
                                <a href="{{ route('categories') }}" class="nav-link px-2"> <span class="d-sm-inline"><i
                                            class="fa-solid fa-table"></i> Categories</span></a>
                            </li>
                            <li class="{{ Route::is('subcategories') ? 'active' : '' }}">
                                <a href="{{ route('subcategories') }}" class="nav-link px-2"> <span
                                        class="d-sm-inline"><i class="fa-solid fa-table"></i> Subcategories</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->can('user_response.view'))
                    <li>
                        <a href="#response_submenu" id="report" data-bs-toggle="collapse"
                            class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fa-solid fa-reply-all"></i></span>
                            <span class="ms-1 d-sm-inline title px-0">Responses</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('user_responses') ? 'show' : '' }}"
                            id="response_submenu" data-bs-parent="#menu">
                            @can('user_response.view')
                                <li class="{{ Route::is('user_response.index') ? 'active' : '' }}">
                                    <a href="{{ url('user_responses') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-reply-all"></i> <span class="d-sm-inline ps-1 mb-1">
                                            User Responses</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->can('question.view') ||
                        Auth::guard('web')->user()->can('sub_question.view') ||
                        Auth::guard('web')->user()->can('answer.view') ||
                        Auth::guard('web')->user()->can('sub_answer.view'))
                    <li>
                        <a href="#ques_ans_submenu" id="report" data-bs-toggle="collapse"
                            class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fa-solid fa-file-circle-question"></i></span>
                            <span class="ms-1 d-sm-inline title px-0">Question & Answer</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('questions') ? 'show' : '' }}"
                            id="ques_ans_submenu" data-bs-parent="#menu">
                            @can('question.view')
                                <li class="{{ Route::is('question.index') ? 'active' : '' }}">
                                    <a href="{{ url('questions') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-question"></i> <span class="d-sm-inline ps-1 mb-1">
                                            Questions</span></a>
                                </li>
                            @endcan
                            @can('sub_question.view')
                                <li class="{{ Route::is('sub_question.index') ? 'active' : '' }}">
                                    <a href="{{ url('sub_questions') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-question"></i> <span class="d-sm-inline ps-1 mb-1"> Sub
                                            Questions</span></a>
                                </li>
                            @endcan
                            @can('answer.view')
                                <li class="{{ Route::is('answer.index') ? 'active' : '' }}">
                                    <a href="{{ url('answers') }}" class="nav-link px-2"><i
                                            class="fa-regular fa-comment"></i><span class="d-sm-inline ps-1 mb-1">
                                            Answers</span></a>
                                </li>
                            @endcan
                            @can('sub_answer.view')
                                <li class="{{ Route::is('sub_answer.index') ? 'active' : '' }}">
                                    <a href="{{ url('sub_answers') }}" class="nav-link px-2"><i
                                            class="fa-regular fa-comment"></i><span class="d-sm-inline ps-1 mb-1"> Sub
                                            Answers</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->can('report.survey'))
                    <li>
                        <a href="#report_submenu" id="report" data-bs-toggle="collapse"
                            class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fas fa-chart-bar"></i></span>
                            <span class="ms-1 d-sm-inline title ">Report</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('survey-report') ? 'show' : '' }}"
                            id="report_submenu" data-bs-parent="#menu">
                            @can('report.survey')
                                <li class="{{ Route::is('survey-report') ? 'active' : '' }}">
                                    <a href="{{ route('survey-report') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-building"></i> <span class="d-sm-inline ps-1 mb-1"> Survey
                                            Report</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->can('user.view') ||
                        Auth::guard('web')->user()->can('user.create') ||
                        Auth::guard('web')->user()->can('role.view') ||
                        Auth::guard('web')->user()->can('role.create'))
                    <li>
                        <a href="#user_submenu1" data-bs-toggle="collapse" class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fa-solid fa-users"></i></span>
                            <span class="ms-1 d-sm-inline title px-0">User Management</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('users.index') || Route::is('users.create') || Route::is('roles.index') || Route::is('roles.create') ? 'show' : '' }}"
                            id="user_submenu1" data-bs-parent="#menu">
                            @if (Auth::guard('web')->user()->can('user.view') ||
                                    Auth::guard('web')->user()->can('user.create'))
                                @can('user.create')
                                    <li class="{{ Route::is('users.create') ? 'active' : '' }}">
                                        <a href="{{ url('users/create') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-pencil"></i> Create
                                                User</span></a>
                                    </li>
                                @endcan
                                @can('user.view')
                                    <li class="{{ Route::is('users.index') ? 'active' : '' }}">
                                        <a href="{{ url('users') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-table"></i> Manage
                                                Users</span></a>
                                    </li>
                                @endcan
                                @can('role.create')
                                    <li class="{{ Route::is('roles.create') ? 'active' : '' }}">
                                        <a href="{{ url('roles/create') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-pencil"></i> Create
                                                Role</span></a>
                                    </li>
                                @endcan
                                @can('role.view')
                                    <li class="{{ Route::is('roles.index') ? 'active' : '' }}">
                                        <a href="{{ url('roles') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-table"></i> Manage
                                                Roles</span></a>
                                    </li>
                                @endcan
                                @can('permission.create')
                                    <li class="{{ Route::is('permission.create') ? 'active' : '' }}">
                                        <a href="{{ url('permissions/create') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-pencil"></i> Create
                                                Permission</span></a>
                                    </li>
                                @endcan
                                @can('permission.view')
                                    <li class="{{ Route::is('permission.index') ? 'active' : '' }}">
                                        <a href="{{ url('permissions') }}" class="nav-link px-2"> <span
                                                class="d-sm-inline"><i class="fa-solid fa-table"></i> Manage
                                                Permission</span></a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->can('company.setting') ||
                        Auth::guard('web')->user()->can('basic.setting') ||
                        Auth::guard('web')->user()->can('theme.setting') ||
                        Auth::guard('web')->user()->can('email.setting') ||
                        Auth::guard('web')->user()->can('approval.setting') ||
                        Auth::guard('web')->user()->can('notification.setting') ||
                        Auth::guard('web')->user()->can('taxbox.setting') ||
                        Auth::guard('web')->user()->can('cron.setting'))
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link ps-1 align-middle">
                            <span class="icon"><i class="fa-solid fa-gear"></i></span>
                            <span class="ms-1 d-sm-inline title ">Settings</span>
                            <i class="icon fa-solid fa-angle-right text-right"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 ps-3 {{ Route::is('company-setting') ||
                        Route::is('basic-setting') ||
                        Route::is('email-setting') ||
                        Route::is('theme-setting') ||
                        Route::is('approval-setting') ||
                        Route::is('notification-setting') ||
                        Route::is('toxbox-setting') ||
                        Route::is('cron-setting')
                            ? 'show'
                            : '' }}"
                            id="submenu1" data-bs-parent="#menu">

                            @can('company.setting')
                                <li class="{{ Route::is('company-setting') ? 'active' : '' }}">
                                    <a href="{{ route('company-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-building"></i> <span class="d-sm-inline ps-1 mb-1"> Company
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('basic.setting')
                                <li class="{{ Route::is('basic-setting') ? 'active' : '' }}">
                                    <a href="{{ route('basic-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-clock"></i> <span class="d-sm-inline ps-1 mb-1"> Basic
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('theme.setting')
                                <li class="{{ Route::is('theme-setting') ? 'active' : '' }}">
                                    <a href="{{ route('theme-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-image"></i> <span class="d-sm-inline ps-1 mb-1"> Theme
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('email.setting')
                                <li class="{{ Route::is('email-setting') ? 'active' : '' }}">
                                    <a href="{{ route('email-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-at"></i>
                                        <span class="d-sm-inline ps-1 mb-1"> Email Settings</span></a>
                                </li>
                            @endcan

                            @can('approval.setting')
                                <li class="{{ Route::is('approval-setting') ? 'active' : '' }}">
                                    <a href="{{ route('approval-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-thumbs-up"></i> <span class="d-sm-inline ps-1 mb-1">
                                            Approval
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('notification.setting')
                                <li class="{{ Route::is('notification-setting') ? 'active' : '' }}">
                                    <a href="{{ route('notification-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-globe"></i> <span class="d-sm-inline ps-1 mb-1">
                                            Notifications
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('toxbox.setting')
                                <li class="{{ Route::is('toxbox-setting') ? 'active' : '' }}">
                                    <a href="{{ route('toxbox-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-comment"></i> <span class="d-sm-inline ps-1 mb-1">ToxBox
                                            Settings</span></a>
                                </li>
                            @endcan
                            @can('cron.setting')
                                <li class="{{ Route::is('cron-setting') ? 'active' : '' }}">
                                    <a href="{{ route('cron-setting') }}" class="nav-link px-2"><i
                                            class="fa-solid fa-rocket"></i> <span class="d-sm-inline ps-1 mb-1">Cron
                                            Settings</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</section>
