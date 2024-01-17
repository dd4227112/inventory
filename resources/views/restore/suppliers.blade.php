@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Deleted Suppliers </h4>
                <h6>Restore/Permanently delete Supplier</h6>
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
                                <th>Name </th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Address</th>
                                <th>Deleted By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$suppliers->isEmpty())
                            @foreach($suppliers as $key => $supplier)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $supplier->name}}</td>
                                <td>{{ $supplier->phone}}</td>
                                <td>{{ $supplier->email}}</td>
                                <td>{{ $supplier->address}}</td>
                                <td>{{ $supplier->deletedBy->name}}</td>
                                <td>
                                    <a class="me-3 restoreSupplier" id="{{$supplier->id }}" href="javascript:void(0);">
                                        <i class="fa fa-undo text-success"></i>
                                    </a>
                                    <a class="me-3 deleteSupplier" id="{{$supplier->id }}" href="javascript:void(0);">
                                        <i class="fa fa-trash text-danger"></i>
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
    //delete Supplier forever
    $(document).on("click", ".deleteSupplier", function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this Supplier! Can't be Restored again!",
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
                    url: "{{url('delete_supplier')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: response.title,
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            if (response.title == 'Deleted!') {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        });
    });
    //  restore payment
    $(document).on("click", ".restoreSupplier", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to Restore  this Supplier!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, restore it!",
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-secondary ml-1",
            buttonsStyling: false
        }).then(function(t) {
            if (t.value && t.dismiss !== "cancel") {
                $.ajax({
                    type: 'POST',
                    url: "{{url('restoreSupplier')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: response.title,
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            if (response.title == 'Restored!') {
                                window.location.reload();
                            }

                        });
                    }
                });
            }
        });
    });
</script>