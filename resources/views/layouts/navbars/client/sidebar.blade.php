@if(Auth::user()->hasRole('Admin'))
    <!-- Admin Navbar -->
        <nav class="sidebar  py-0 mb-0"> 
            <ul class="nav flex-column" id="nav_accordion">
                <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ Route::currentRouteName() == 'profile' ? 'show active' : '' }}" href="{{ route('profile') }}"> 
                        <div class="ps-0 mb-0">
                            <i class="fa fa-user pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">User Information</span> 
                    </a>
                    {{-- <ul class="submenu collapse {{ Route::currentRouteName() == 'profile' ? 'show' : '' }}"> --}}
                        {{-- <li><a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}"> Profile </a></li> --}}
                        {{-- <li><a class="nav-link" href="#">Directory </a></li>
                        <li><a class="nav-link" href="#">Submenu item 3 </a> </li> --}}
                    {{-- </ul> --}}
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ request()->segment(2) == 'users' ? 'active' : '' }}" {{ request()->segment(1) == 'manage' ? 'show' : '' }}" href="{{ route('users.index') }}"> 
                        <div class="ps-0 mb-0">
                            <i class="fas fa-users pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">User Manager </span> 
                    </a>
                    {{-- <ul class="submenu collapse rounded  {{ request()->segment(1) == 'manage' ? 'show' : '' }}"> --}}
                        {{-- <li><a class="nav-link rounded {{ request()->segment(2) == 'users' ? 'active' : '' }}" href="{{ route('users.index') }}">User </a></li> --}}
                        {{-- <li><a class="nav-link rounded {{ request()->segment(2) == 'users' ? 'active' : '' }}" href="{{ route('users.index') }}">Saldo</a></li> --}}
                    {{-- </ul> --}}
                </li>
                {{-- <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ request()->segment(1) == 'manage' ? 'show' : '' }}" href="#"> 
                        <div class="ps-0 mb-0">
                            <i class="fa fa-database pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">Database Manager </span> 
                    </a>
                    <ul class="submenu collapse rounded  {{ request()->segment(1) == 'manage' ? 'show' : '' }}">
                        <li><a class="nav-link rounded {{ request()->segment(2) == 'users' ? 'active' : '' }}" href="{{ route('users.index') }}">Backup</a></li>
                    </ul>
                </li> --}}
                <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ request()->segment(1) == 'manage' ? 'show' : '' }}" href="#"> 
                        <div class="ps-0 mb-0">
                            <i class="fas fa-server pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">Server</span> 
                    </a>
                    <ul class="submenu collapse rounded {{ request()->segment(1) == 'filemanager' ? 'show' : '' }} {{ request()->segment(1) == 'backup' ? 'show' : '' }}">
                        <li><a class="nav-link rounded {{ request()->segment(1) == 'filemanager' ? 'active' : '' }}" href="{{route('filemanager')}}"><i class="fas fa-folder pe-3" style="color: #f4645f;"></i> File Manager</a></li>
                        {{-- <li><a class="nav-link rounded {{ request()->segment(2) == 'log' ? 'active' : '' }}" href="{{route('log-viewer.index')}}"><i class="fas fa-clipboard-list pe-3" style="color: #f4645f;"></i> Log System</a></li> --}}
                        <li><a class="nav-link rounded {{ request()->segment(1) == 'backup' ? 'active' : '' }}" href="{{ route('backup') }}"><i class="fas fa-database pe-3" style="color: #f4645f;"></i> Backup</a></li>
                    </ul>
                </li>    

                {{-- <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ request()->segment(1) == 'configure' ? 'show' : '' }}" href="#"> 
                        <div class="ps-0 mb-0">
                            <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">Configure </span> 
                    </a>
                    <ul class="submenu collapse rounded  {{ request()->segment(1) == 'configure' ? 'show' : '' }}">
                        <li><a class="nav-link rounded {{ request()->segment(2) == 'company' ? 'active' : '' }}" href="{{ route('company.index') }}">Company </a></li>
                        <li><a class="nav-link rounded {{ request()->segment(2) == 'directory' ? 'active' : '' }}" href="{{ route('directory.index') }}">Directory </a></li>
                    </ul>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link rounded border-0 mt-0 d-flex align-items-center" href="#"> 
                        <div class="ps-0 mb-0">
                            <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                        </div> 
                        <span class="text-uppercase text-xs font-weight-bolder opacity-6">Stemp Process</span> 
                    </a>
                    <ul class="submenu collapse rounded {{ request()->segment(1) == 'stemp' ? 'show' : '' }}">

                    </ul>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#"> Other link </a>
                </li> --}}
            </ul>
        </nav>  
        <!-- Navbar -->


@endif


@if(Auth::user()->hasRole('Client'))
<!-- Client Navbar -->
<nav class="sidebar  py-0 mb-0"> 
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item has-submenu">
            <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ Route::currentRouteName() == 'profile' ? 'show' : '' }}" href="{{ route('profile') }}" href="#"> 
                <div class="ps-0 mb-0">
                    <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                </div> 
                <span class="text-uppercase text-xs font-weight-bolder opacity-6">User Information</span> 
            </a>
            <ul class="submenu collapse {{ Route::currentRouteName() == 'profile' ? 'show' : '' }}">
                <li><a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}"> Profile </a></li>
                {{-- <li><a class="nav-link" href="#">Directory </a></li>
                <li><a class="nav-link" href="#">Submenu item 3 </a> </li> --}}
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a class="nav-link rounded border-0 mt-0 d-flex align-items-center {{ request()->segment(1) == 'configure' ? 'show' : '' }}" href="#"> 
                <div class="ps-0 mb-0">
                    <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                </div> 
                <span class="text-uppercase text-xs font-weight-bolder opacity-6">Configure</span> 
            </a>
            <ul class="submenu collapse rounded  {{ request()->segment(1) == 'configure' ? 'show' : '' }}">
                <li><a class="nav-link rounded {{ request()->segment(2) == 'company' ? 'active' : '' }}" href="{{ route('company.index') }}">Company </a></li>
                <li><a class="nav-link rounded {{ request()->segment(2) == 'directory' ? 'active' : '' }}" href="{{ route('directory.index') }}">Directory </a></li>
                {{-- <li><a class="nav-link rounded {{ request()->segment(2) == 'other' ? 'active' : '' }}" href="{{ route('company.index') }}">Submenu item 3 </a> </li> --}}
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a class="nav-link rounded border-0 mt-0 d-flex align-items-center" href="#"> 
                <div class="ps-0 mb-0">
                    <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                </div> 
                <span class="text-uppercase text-xs font-weight-bolder opacity-6">Stamp Process</span> 
            </a>
            <ul class="submenu collapse rounded {{ request()->segment(1) == 'stemp' ? 'show' : '' }}">
                <li><a class="nav-link rounded {{ request()->segment(2) == 'company' ? 'active' : '' }}" href="{{route('company')}}">New </a></li>
                <li><a class="nav-link rounded {{ request()->segment(2) == 'progress' ? 'active' : '' }}" href="{{route('progress')}}">In Progress </a></li>
                <li><a class="nav-link rounded {{ request()->segment(2) == 'failed' ? 'active' : '' }}" href="{{route('failed')}}">Failed </a></li>
                
                {{-- <li><a class="nav-link rounded" href="#">On Process </a></li> --}}
                <li><a class="nav-link rounded {{ request()->segment(2) == 'success' ? 'active' : '' }}" href="{{route('success')}}">Success </a></li>
                <li><a class="nav-link rounded {{ request()->segment(2) == 'history' ? 'active' : '' }}" href="{{route('history')}}">History </a></li>
                {{-- <li><a class="nav-link rounded" href="#">Failure </a></li> --}}
                {{-- <li><a class="nav-link rounded" href="#">Submenu item 3 </a> </li> --}}
            </ul>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" href="#"> Other link </a>
        </li> --}}
    </ul>
</nav>  
<!-- Navbar -->
@endif

