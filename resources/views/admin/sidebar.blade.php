<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{ url('/dashboard')}}"><img src="{{ asset('assets/img/icons/dashboard.svg')}}" alt="img"><span> Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg')}}" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('list_product')}}">Product List</a></li>
                        <li><a href="{{ route('add_product')}}">Add Product</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/sales1.svg')}}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('list_sale') }}">List Sales</a></li>
                        <li><a href="{{ route('add_sale')}}">Add Sale</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src=" {{ asset('assets/img/icons/purchase1.svg')}}" alt="img"><span> Purchases</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('list_purchase') }}">List Purchases</a></li>
                        <li><a href="{{ route('add_purchase')}}">Add Purchase</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg')}}" alt="img"><span>
                            People</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('list_customer')}}">Customer List</a></li>
                        <li><a href="{{ route('add_customer')}}">Add Customer </a></li>
                        <li><a href="{{ route('list_supplier')}}">Supplier List</a></li>
                        <li><a href="{{ route('add_supplier')}}">Add Supplier </a></li>
                        <li><a href="{{ route('admin.list_user')}}">List Users</a></li>
                        <li><a href="{{ route('admin.add_user')}}">Add User </a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/time.svg')}}" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('productreport')}} ">Products report</a></li>
                        <li><a href="{{route('purchasereport')}}">Purchase Report</a></li>
                        <li><a href="{{route('salesreport')}}">Sales Report</a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-university"></i><span> Shops</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('admin.list_shop') }}">List Shops</a></li>
                        <li><a href="{{ route('admin.add_shop') }}">Add Shop </a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/settings.svg')}}" alt="img"><span> Account</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('profile')}}">Profile</a></li>
                        <li><a href="{{route('password')}}">Password</a></li> 
                        <li><a href="{{ route('logout') }}">Logout</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>