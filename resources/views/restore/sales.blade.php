@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Deleted Sales </h4>
                <h6>Restore/Permanently delete Sale</h6>
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
                                <th>Customer Name</th>
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
                            @if(!$sales->isEmpty())
                            @foreach($sales as $key => $sale)
                            <tr>
                                <td>{{ ++ $key}}</td>
                                <td>{{ $sale->date }}</td>
                                <td> {{ $sale->customer->name}}</td>
                                <td>{{ $sale->reference }}</td>
                                <td><span class="badges bg-lightgreen">Completed</span></td>
                                @if($sale->grand_total == $payments[$sale->id] )
                                <td><span class="badges bg-lightgreen">Completed</span></td>
                                @elseif(( $payments[$sale->id] < $sale->grand_total) && ($payments[$sale->id] > 0))
                                    <td> <span class="badges bg-lightyellow">Partial</span></td>
                                    @else
                                    <td><span class="badges bg-lightred">Pending</span></td>
                                    @endif
                                    <td style="text-align: right;">{{ number_format($sale->grand_total,2) }}</td>
                                    <td style="text-align: right;">{{ number_format($payments[$sale->id],2) }}</td>
                                    <td style="text-align: right;">{{ number_format(($sale->grand_total - $payments[$sale->id] ),2) }}</td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>{{ $sale->deletedBy->name }}</td>
                                    <td>
                                        @if(can_access('edit_product'))
                                        <a class="me-3 restoreSale" id="{{$sale->id }}" href="javascript:void(0);">
                                            <i class="fa fa-undo text-success"></i>
                                        </a>
                                        @endif
                                        @if(can_access('delete_product'))
                                        <a class="me-3 deleteSale" id="{{$sale->id }}" href="javascript:void(0);">
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
    //delete Sale forever
    $(document).on("click", ".deleteSale", function() {
        var id = $(this).attr('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this Sale! Can't be Restored again!",
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
                    url: "{{url('delete_sale')}}",
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
    //  restore sale
    $(document).on("click", ".restoreSale", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to Restore  this Sale!",
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
                    url: "{{url('restoreSale')}}",
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