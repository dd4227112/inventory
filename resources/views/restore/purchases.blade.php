@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
            <h4>Deleted Purchases </h4>
                <h6>Restore/Permanently delete purchase</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
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
                                <th>Date</th>
                                <th>Supplier Name</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Biller</th>
                                <th>Deleted By</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$purchases->isEmpty())
                            @foreach($purchases as $key => $purchase)
                            <tr>
                                <td>{{ ++ $key}}</td>
                                <td>{{ $purchase->date }}</td>
                                <td> {{ $purchase->supplier->name}}</td>
                                <td>{{ $purchase->reference }}</td>
                                <td><span class="badges bg-lightgreen">Completed</span></td>
                                @if($purchase->grand_total == $payments[$purchase->id] )
                                <td><span class="badges bg-lightgreen">Completed</span></td>
                                @elseif(( $payments[$purchase->id] < $purchase->grand_total) && ($payments[$purchase->id] > 0))
                                    <td> <span class="badges bg-lightyellow">Partial</span></td>
                                    @else
                                    <td><span class="badges bg-lightred">Pending</span></td>
                                    @endif
                                    <td style="text-align: right;">{{ number_format($purchase->grand_total,2) }}</td>
                                    <td style="text-align: right;">{{ number_format($payments[$purchase->id], 2) }}</td>
                                    <td style="text-align: right;">{{ number_format(($purchase->grand_total - $payments[$purchase->id]), 2) }}</td>

                                    <td>{{ $purchase->user->name }}</td>
                                    <td>{{ $purchase->deletedBy->name }}</td>
                                    <td>
                                        @if(can_access('edit_purchase'))
                                        <a class="me-3 restorePurchase" id="{{$purchase->id }}" href="javascript:void(0);">
                                            <i class="fa fa-undo text-success"></i>
                                        </a>
                                        @endif
                                        @if(can_access('delete_purchase'))
                                        <a class="me-3 deletePurchase" id="{{$purchase->id }}" href="javascript:void(0);">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                        @endif
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
<!-- page end -->
@include('authentication.footer')
<script>
    //delete Purchase forever
    $(document).on("click", ".deletePurchase", function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this Purchase! Can't be Restored again!",pul
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
                    url: "{{url('delete_purchase')}}",
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
    $(document).on("click", ".restorePurchase", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to Restore  this Purchase!",
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
                    url: "{{url('restorePurchase')}}",
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
