<div class="header">

    <div class="header-left active">
        <a href="index.html" class="logo">
            <img src="{{ asset('assets/img/logo.png')}}" alt="">
        </a>
        <a href="index.html" class="logo-small">
            <img src="{{ asset('assets/img/logo-small.png')}}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
        </a>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <ul class="nav user-menu">

        <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="#">
                    <div class="searchinputs">
                        <input type="text" placeholder="Search Here ...">
                        <div class="search-addon">
                            <span><img src="{{ asset('assets/img/icons/closes.svg')}}" alt="img"></span>
                        </div>
                    </div>
                    <a class="btn" id="searchdiv"><img src="{{ asset('assets/img/icons/search.svg')}}" alt="img"></a>
                </form>
            </div>
        </li>


        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{ asset('uploads/profiles/'.Auth::User()->photo)}}" alt="Photo">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ asset('uploads/profiles/'.Auth::User()->photo)}}" alt="Photo">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>{{ Auth::user()->name }}</h6>
                            <h6>{{ Auth::user()->role->name}}</h6>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html"><i class="me-2" data-feather="settings"></i>Settings</a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="{{ route('logout') }}"><img src="{{ asset('assets/img/icons/log-out.svg')}}" class="me-2" alt="img">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</div>
<div id="global-loader">
    <div class="whirly-loader"> </div>
</div>
<div class="main-wrapper">