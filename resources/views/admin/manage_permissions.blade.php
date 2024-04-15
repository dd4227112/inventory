@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage User Permissions</h4>
                <hr>
                <h4>{{ $user->name }} - ({{$user->role->name }})</h4>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="{{asset('assets/img/icons/search-white.svg')}}" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Grant/Deny Permission</th>
                            </tr>
                        </thead>
                        <tbody>


                            @if(!$permissions->isEmpty())
                            <tr>
                                <td> -</td>
                                <td class="text-danger"><b>Grant/Deny All Permissions to User</b></td>
                                <td>
                                    <div class="form-switch">
                                        <input class="form-check-input checkAll " id= "" type="checkbox" {{$all_given}}
                                            id="allPermission">
                                        <label class="form-check-label text-danger" for="allPermission">Grant/Deny
                                            All</label>
                                    </div>
                                </td>
                            </tr>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name}} </td>
                                <td>{{ $permission->description}} </td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="{{$permission->id}}" class="check" {{ $checked[$permission->id]}}>
                                        <label for="{{$permission->id}}" class="checktoggle">checkbox</label>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <input type="hidden" value="{{ $user->id }}" name="user_id" id="user_id">
                </div>
            </div>
        </div>

    </div>
</div>
<!-- page content end -->

@include('authentication.footer')
<script>
    checktoggle = $('.check').change(function() {
        var id = $(this).attr('id');
        if ($(this).is(':checked')) {
            var checked = true;
        } else {
            var checked = false;
        }
        var user_id = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: "{{url('update_permission')}}",
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                user_id: user_id,
                checked: checked
            },
            success: function(response) {
                alertify[response.class](response.message)

            }
        });
    });
    $(document).ready(checktoggle);

    $(document).on("change", ".checkAll", function() {
        if ($(this).is(':checked')) {
            var checked = true;
        } else {
            var checked = false;
        }
        var user_id = $('#user_id').val();
        Swal.fire({
            title: "Are you sure?",
            text: "You want to grant/deny all permission to user",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('allPermission') }}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        user_id: user_id,
                        checked: checked
                    },
                    success: function(response) {
                        Swal.fire({
                            title: response.title,
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            window.location.reload();
                        });


                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            }
        });
    });
</script>