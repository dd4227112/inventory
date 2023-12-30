@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales Management</h4>
                <h6>List Sales</h6>
            </div>
            <div class="page-btn">
                <a href=" {{ route('add_sale')}}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">Add Sales</a>
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
                                    <td class="text-center">
                                        <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('view_sale',   $sale->uuid) }}" class="dropdown-item"><img src="{{ asset('assets/img/icons/eye1.svg')}}" class="me-2" alt="img">Sale
                                                    Detail</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('edit_sale', $sale->uuid) }}" class="dropdown-item"><img src="{{ asset('assets/img/icons/edit.svg')}}" class="me-2" alt="img">Edit
                                                    Sale</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item showpayment" id="{{ $sale->id}}"><img src="{{ asset('assets/img/icons/dollar-square.svg')}}" class="me-2" alt="img">Show Payments</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item createpayment" id="{{ $sale->uuid }}"><img src="{{ asset('assets/img/icons/plus-circle.svg')}}" class="me-2" alt="img">Add Payment</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('print_sale', $sale->uuid ) }}" class="dropdown-item"><img src="{{ asset('assets/img/icons/printer.svg')}}" class="me-2" alt="img">Invoice/Slip</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item delete_sale" id="{{$sale->id }}"><img src="{{ asset('assets/img/icons/delete1.svg')}}" class="me-2" alt="img">Delete Sale</a>
                                            </li>
                                        </ul>
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

<!-- add payemnt modal -->
<div class="modal fade" id="createpayment" tabindex="-1" aria-labelledby="createpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('store_sale_payment') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="input-groupicon">
                                    <input type="text" value="" id="customer" readonly class="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-groupicon">
                                    <input type="date" required value="{{date('Y-m-d')}}" name="date" class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Reference</label>
                                <input type="text" name="reference" readonly value="{{reference() }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" id="purchase_amount" name="balance" readonly value="0.00">
                                <input type="hidden" id="sale_id" name="sale_id" value="0.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Paying Amount</label>
                                <input type="text" value="" id="amount" required name="amount" min="1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select class="select" name="payment_method">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank</option>
                                    <option value="3">Credit Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label>Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-submit">Submit</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('sales.actions');
@include('authentication.footer')
<script src="{{ asset('/assets/js/sales.js')}}"></script>
<script>
    show_payment = $('.showpayment').on('click', function() {
        var sale_id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: "{{url('singleSalePayment')}}",
            dataType: 'html',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: sale_id
            },
            success: function(response) {
                $('#payment').html(response);
                $('#showpayment').modal('show');
            }
        });

    });
    $(document).ready(show_payment);

    $(document).on("click", ".deletePayment", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this payment!",
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
                    url: "{{url('deletepayment')}}",
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
    $(document).on("click", ".getPayment", function() {
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: "{{url('getsinglepayment')}}",
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id
            },
            success: function(response) {
                $('#amounts').val(response.amount);
                $('#customers').val(response.customer);
                $('#payment_id').val(response.payment_id);
                $('#reference').val(response.reference);
                $('#description').val(response.description);
                $('#date').val(response.date);
                $('#balance').val(response.balance);

                $('#editpayment').modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>