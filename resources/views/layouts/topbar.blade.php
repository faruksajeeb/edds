<div class="topbar row m-0 p-0  sticky-top ">
    <div class="col-md-1 m-0 p-0 ">
        <div class="toggle  float-start" onclick="toggleMenu()">
        </div>
    </div>
    <div class="col-md-5 m-0 p-0 ">
        {{-- <div class="search ">
            <label for="">
                <input type="text" placeholder="Search here" class=" form-control" />
                <i class="fa fa-solid fa-magnifying-glass"></i>
            </label>
        </div> --}}
    </div>
    <div class="col-md-6 m-0 p-3 ">        
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
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a  href="{{ url('clear') }}"  class="dropdown-item" >clear all</a>
                </li>
            </ul>
        </div>
    </div>
</div>
