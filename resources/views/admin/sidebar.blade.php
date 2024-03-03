<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{$active=='dashboard'?'active':''}}">
                    <a href="{{ url('/dashboard')}}"><img src="{{ asset('assets/img/icons/dashboard.svg')}}" alt="img"><span> Dashboard</span> </a>
                </li>
                @if(can_access('manage_products'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg')}}" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_products'))
                        <li><a href="{{ route('list_product')}}" class="{{$active=='list_product'?'active':''}}">Product List</a></li>
                        @endif
                        @if(can_access('add_product'))
                        <li><a href="{{ route('add_product')}}" class="{{$active=='add_product'?'active':''}}">Add Product</a></li>
                        @endif

                    </ul>
                </li>
                @endif
                @if(can_access('manage_sale'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/sales1.svg')}}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                    @if(can_access('list_sales'))
                        <li><a href="{{ route('pos_sale') }}" class="{{$active=='pos'?'active':''}}">POS</a></li>
                        @endif
                        @if(can_access('list_sales'))
                        <li><a href="{{ route('list_sale') }}" class="{{$active=='list_sale'?'active':''}}">List Sales</a></li>
                        @endif
                        @if(can_access('add_sale'))
                        <li><a href="{{ route('add_sale')}}" class="{{$active=='add_sale'?'active':''}}">Add Sale</a></li>
                        @endif

                    </ul>
                </li>
                @endif
                @if(can_access('manage_purchase'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src=" {{ asset('assets/img/icons/purchase1.svg')}}" alt="img"><span> Purchases</span> <span class="menu-arrow"></span></a>
                    <ul>

                        @if(can_access('list_purchases'))
                        <li><a href="{{ route('list_purchase') }}" class="{{$active=='list_purchase'?'active':''}}">List Purchases</a></li>
                        @endif
                        @if(can_access('add_purchase'))
                        <li><a href="{{ route('add_purchase')}}" class="{{$active=='add_purchase'?'active':''}}">Add Purchase</a></li>
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
                        <li><a href="{{ route('list_customer')}}" class="{{$active=='list_customer'?'active':''}}">Customer List</a></li>
                        @endif
                        @if(can_access('add_customer'))
                        <li><a href="{{ route('add_customer')}}"  class="{{$active=='add_customer'?'active':''}}">Add Customer </a></li>
                        @endif
                        @if(can_access('list_suppliers'))
                        <li><a href="{{ route('list_supplier')}}" class="{{$active=='list_supplier'?'active':''}}">Supplier List</a></li>
                        @endif
                        @if(can_access('add_supplier'))
                        <li><a href="{{ route('add_supplier')}}" class="{{$active=='add_supplier'?'active':''}}">Add Supplier </a></li>
                        @endif
                        @if(can_access('list_users'))
                        <li><a href="{{ route('admin.list_user')}}" class="{{$active=='list_user'?'active':''}}">List Users</a></li>
                        @endif
                        @if(can_access('add_user'))
                        <li><a href="{{ route('admin.add_user')}}" class="{{$active=='add_user'?'active':''}}">Add User </a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(can_access('view_report'))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/time.svg')}}" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('productreport')}}" class="{{$active=='product_report'?'active':''}}">Products report</a></li>
                        <li><a href="{{route('purchasereport')}}" class="{{$active=='purchase_report'?'active':''}}">Purchase Report</a></li>
                        <li><a href="{{route('salesreport')}}" class="{{$active=='sale_report'?'active':''}}">Sales Report</a></li>

                    </ul>
                </li>
                @endif
                @if(can_access('manage_shops'))
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-university"></i><span> Shops</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(can_access('list_shops'))
                        <li><a href="{{route('admin.list_shop') }}" class="{{$active=='list_shop'?'active':''}}">List Shops</a></li>
                        @endif
                        @if(can_access('add_shop'))
                        <li><a href="{{ route('admin.add_shop') }}" class="{{$active=='add_shop'?'active':''}}">Add Shop </a></li>
                        @endif

                    </ul>
                </li>
                @endif
                @if(can_access('manage_setting') || Auth::user()->role->name =='Admin')
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/settings.svg')}}" alt="img"><span> settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(Auth::user()->role->name =='Admin')
                        <li><a href="{{route('user_permission') }}" class="{{$active=='user_permission'?'active':''}}">User Permissions</a></li>
                        @endif
                        @if(can_access('manage_trash'))
                        <li><a href="{{route('admin.trash') }}" class="{{$active=='trash'?'active':''}}">Trash</a></li>
                        @endif
                        @if(Auth::user()->role->name =='Admin' || Auth::user()->role->name =='Auditor')
                        <li><a href="{{route('admin.list_units') }}" class="{{$active=='units'?'active':''}}">Units</a></li>
                        @endif
                        @if(Auth::user()->role->name =='Admin' || Auth::user()->role->name =='Auditor')
                        <li><a href="{{route('admin.list_category') }}" class="{{$active=='categories'?'active':''}}">Categories</a></li>
                        @endif
                        @if(Auth::user()->role->name =='Admin' || Auth::user()->role->name =='Auditor')
                        <li><a href="{{route('admin') }}" class="{{$active=='switch_shop'?'active':''}}">Switch Shop</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg')}}" alt="img"><span> Account</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{route('profile')}}"  class="{{$active=='profile'?'active':''}}">Profile</a></li>
                        <li><a href="{{route('password')}}" class="{{$active=='password'?'active':''}}">Password</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>