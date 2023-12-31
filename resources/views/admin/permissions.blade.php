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
                <a href="{{route('admin.add_user')}}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-2">Add User</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="{{ asset('assets/img/icons/search-white.svg')}}" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{ asset('assets/img/icons/excel.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{ asset('assets/img/icons/printer.svg')}}" alt="img"></a>
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
                                <th>Role</th>
                                <th>Permission</th>
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
                                <td>{{ $user->role->name}}</td>
                                <td>
                                    <a class="me-3" title ="View/Edit user permissions" href="{{ route('manage_permission', $user->uuid)}}">
                                        <img src="{{ asset('assets/img/icons/eye.svg')}}"   alt="img">
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
<script>
    $(document).on("click", ".delete", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this User!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-danger",
            cancelButtonClass: "btn btn-secondary ml-1",
            buttonsStyling: false
        }).then(function(t) {
            if (t.value && t.dismiss !== "cancel") {
                $.ajax({
                    type: 'POST',
                    url: "{{url('deleteuser')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: "Deleted!",
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    });

    $(document).on("click", ".reset", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to reset password for this User!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reset it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-secondary ml-1",
            buttonsStyling: false
        }).then(function(t) {
            if (t.value && t.dismiss !== "cancel") {
                $.ajax({
                    type: 'POST',
                    url: "{{url('resetuser')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: "Deleted!",
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        });
                    }
                });
            }
        });
    });
</script>