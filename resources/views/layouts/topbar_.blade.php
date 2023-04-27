<div class="topbar  sticky-top">
    <div class="row m-0 p-0">
        <div class="col-md-8 m-0 p-0 bg-success w-100 h-100">

            <div class="toggle  " onclick="toggleMenu()">

            </div>
            <div class="search float-right">
                <label for="">
                    <input type="text" placeholder="Search here" />
                    <i class="fa fa-solid fa-magnifying-glass"></i>
                </label>
            </div>
            <a href="{{ url('clear') }}" class="float-end">clear all</a>
            <div class="dropdown user float-end">

                <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/user.png') }}" alt="hugenerd" width="30" height="30"
                        class="rounded-circle float-end ">

                    <span class="d-none d-sm-inline mx-1">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
                    @can('change.password')
                        <li><a class="dropdown-item" href="{{ route('change-password') }}">Change Password</a></li>
                    @endcan
                    {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                    @can('user.profile')
                        <li><a class="dropdown-item" href="{{ route('user-profile') }}">Profile</a></li>
                    @endcan
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="#">Sign out</a> --}}
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link class="text-decoration-none" :href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
