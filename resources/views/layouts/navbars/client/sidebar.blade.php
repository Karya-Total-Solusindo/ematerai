<nav class="sidebar  py-0 mb-0"> 
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item has-submenu ">
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
            <a class="nav-link rounded border-0 mt-0 d-flex align-items-center" href="#"> 
                <div class="ps-0 mb-0">
                    <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                </div> 
                <span class="text-uppercase text-xs font-weight-bolder opacity-6">Configure</span> 
            </a>
            <ul class="submenu collapse rounded">
                <li><a class="nav-link rounded" href="{{ route('company.index') }}">Company </a></li>
                <li><a class="nav-link rounded" href="{{ route('directory.index') }}">Directory </a></li>
                <li><a class="nav-link rounded" href="{{ route('company.index') }}">Submenu item 3 </a> </li>
            </ul>
        </li>
        <li class="nav-item has-submenu">
            <a class="nav-link rounded border-0 mt-0 d-flex align-items-center" href="#"> 
                <div class="ps-0 mb-0">
                    <i class="fa fa-folder pe-3" style="color: #f4645f;"></i>
                </div> 
                <span class="text-uppercase text-xs font-weight-bolder opacity-6">Stemp Process</span> 
            </a>
            <ul class="submenu collapse rounded">
                <li><a class="nav-link rounded" href="#">New </a></li>
                <li><a class="nav-link rounded" href="#">On Process </a></li>
                <li><a class="nav-link rounded" href="#">Submenu item 3 </a> </li>
            </ul>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="#"> Other link </a>
        </li>
    </ul>
</nav>  