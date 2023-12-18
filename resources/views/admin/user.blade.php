@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
            <h4>User Management</h4>
                <h6>List Users</h6>
            </div>
            <div class="page-btn">
                <a href="{{route('admin.add_user')}}" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-2">Add User</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name </th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Shop</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$users->isEmpty())
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ asset('uploads/profiles/'.$user->photo)}}" alt="">
                                    </a>
                                </td>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->phone}}</td>
                                <td>{{ $user->email}}</td>
                                <td>@if(isset($user->shop)){{$user->shop->name}} - {{ $user->shop->location }}@endif</td>
                                <td>{{ $user->role->name}}</td>
                                <td>
                                    <a class="me-3" href="edituser.html">
                                        <img src="assets/img/icons/edit.svg"   alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" id= "{{$user->id }}" href="javascript:void(0);">
                                        <img src="assets/img/icons/delete.svg" alt="img">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')