<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{ url('/dashboard')}}"><img src="{{ asset('assets/img/icons/dashboard.svg')}}" alt="img"><span> Dashboard</span> </a>
                </li>
                @if(can_access('manage_products'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg')}}" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_products'))
                        <li><a href="{{ route('list_product')}}">Product List</a></li>
                        @endif
                        @if(can_access('add_product'))
                        <li><a href="{{ route('add_product')}}">Add Product</a></li>
                        @endif

                    </ul>
                </li>
                @endif
                @if(can_access('manage_sale'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/sales1.svg')}}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_sales'))
                        <li><a href="{{ route('list_sale') }}">List Sales</a></li>
                        @endif
                        @if(can_access('add_sale'))
                        <li><a href="{{ route('add_sale')}}">Add Sale</a></li>
                        @endif

                    </ul>
                </li>
                @endif
                @if(can_access('manage_purchase'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src=" {{ asset('assets/img/icons/purchase1.svg')}}" alt="img"><span> Purchases</span> <span class="menu-arrow"></span></a>
                    <ul>

                        @if(can_access('list_purchases'))
                        <li><a href="{{ route('list_purchase') }}">List Purchases</a></li>
                        @endif
                        @if(can_access('add_purchase'))
                        <li><a href="{{ route('add_purchase')}}">Add Purchase</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(can_access('manage_people'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg')}}" alt="img"><span>
                            People</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_customers'))
                        <li><a href="{{ route('list_customer')}}">Customer List</a></li>
                        @endif
                        @if(can_access('add_customer'))
                        <li><a href="{{ route('add_customer')}}">Add Customer </a></li>
                        @endif
                        @if(can_access('list_suppliers'))
                        <li><a href="{{ route('list_supplier')}}">Supplier List</a></li>
                        @endif
                        @if(can_access('add_supplier'))
                        <li><a href="{{ route('add_supplier')}}">Add Supplier </a></li>
                        @endif
                        @if(can_access('list_users'))
                        <li><a href="{{ route('admin.list_user')}}">List Users</a></li>
                        @endif
                        @if(can_access('add_user'))
                        <li><a href="{{ route('admin.add_user')}}">Add User </a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(can_access('view_report'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/time.svg')}}" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('productreport')}} ">Products report</a></li>
                        <li><a href="{{route('purchasereport')}}">Purchase Report</a></li>
                        <li><a href="{{route('salesreport')}}">Sales Report</a></li>

                    </ul>
                </li>
                @endif
                @if(can_access('manage_shops'))
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-university"></i><span> Shops</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_shops'))
                        <li><a href="{{route('admin.list_shop') }}">List Shops</a></li>
                        @endif
                        @if(can_access('add_shop'))
                        <li><a href="{{ route('admin.add_shop') }}">Add Shop </a></li>
                        @endif

                    </ul>
                </li>
                @endif
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg')}}" alt="img"><span> Account</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('profile')}}">Profile</a></li>
                        <li><a href="{{route('password')}}">Password</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>

                    </ul>
                </li>
                @if(can_access('manage_setting'))
                <li class="submenu">
                <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/settings.svg')}}" alt="img"><span> settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('user_permission'))
                        <li><a href="{{route('user_permission') }}">User Permissions</a></li>
                        @endif
                        @if(can_access('manage_trash'))
                        <li><a href="{{route('admin.trash') }}">Trash</a></li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>