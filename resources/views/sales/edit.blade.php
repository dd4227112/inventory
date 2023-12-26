@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<style>
    .pick_product {
        cursor: pointer;

    }

    input[type="number"],
    input[type="text"] {
        border: none;
        background-color: inherit;
    }
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4> Sale Management</h4>
                <h6>Add sale</h6>
            </div>
        </div>
        <form action="{{ route('update_sale')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select class="select2" id="getCustomer" required name="customer_id">
                                            <option value="{{ $sale->customer->id}}" selected>{{ $sale->customer->name}}</option>
                                        </select>
                                        <input type="hidden" value="{{ $sale->id}}" name="sale_id">
                                    </div>
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                        <div class="add-icon">
                                            <span class="add_customer"><img src="{{ asset('assets/img/icons/plus1.svg')}}" alt="img"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-groupicon">
                                    <input type="date" class="form-control" value="{{ $sale->date }}" name="date">
                                    <!-- <div class="addonset">
                                    <img src="{{ asset('assets/img/icons/calendars.svg')}}" alt="img">
                                </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Reference/Invoice No.</label>
                                <input type="text" name="reference" value="{{ $sale->reference }} " readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Search Product</label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="Please type product name or code and select..." id="serchProduct" name="searchProduct">
                                    <div class="addonset">
                                        <img src="{{ asset('assets/img/icons/scanner.svg')}}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6col-sm-6 col-6" id="searchResult">

                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="selectedProduct">
                                    @foreach ($items as $item)
                                    <tr>
                                        <td class=" ">{{ $item->product->name }} ( {{ $item->product->code }} ) - {{ $item->product->description }}</td>
                                        <input class="" type='hidden' id='product_id' name='product_id[]' value="{{ $item->product->id }}">
                                        <td><input type='number' id='quantity' max=" {{$item->product->quantity }}" name='quantity[]' value='{{ $item->quantity }}'></td>
                                        <td><input type='text' id='price' readonly name='price[]' value="{{ $item->price }}"></td>
                                        <td><input type='text' id='sub_total' readonly name='sub_total[]' value="{{ $item->total}}"></td>
                                        <td><a href="javascript:void(0);" id='remove'><img src="{{ asset('assets/img/icons/delete.svg')}}"> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row" style="border: 1px solid #ff9f43; margin-left: 1px; margin-bottom: 5px;border-radius:5px;">
                            <div class="col-lg-6 ">
                                <div class="total-order w-100 max-widthauto m-auto mb-4">

                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="total-order w-100 max-widthauto m-auto mb-4">
                                    <ul>
                                        <li>
                                            <h4>Quantity</h4>
                                            <h5 id="total_items"></h5>
                                        </li>
                                        <li>
                                            <h4>Sub Total</h4>
                                            <h5 id="grand_sub_total"> {{$sale->grand_total }}</h5>
                                        </li>
                                        <li>
                                            <h4>Tax</h4>
                                            <h5 id="">0</h5>
                                        </li>
                                        <li class="total">
                                            <input type="hidden" name="grand_total" value="" id="grand_sub">
                                            <h4>Grand Total</h4>
                                            <h5 id="grand_total">{{$sale->grand_total}}</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="modal-title">Payment</h5>
                            @if(isset($payment) && $payment != 'multiple')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Reference</label>
                                            <input type="text" name="payment_reference" readonly value="{{isset($payment)?$payment->reference:reference() }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" id="payment_amount" name="payment_amount" value="{{isset($payment)?$payment->amount:'' }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-12">
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
                                            <textarea class="form-control" name="description"> {{isset($payment)?$payment->description:'' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <p>Multiple Payment Found.</p>

                                    Click here to manage payment records <a href="javascript:void(0);" class="btn btn-success btn-sm showpayment" id="{{ $sale->id}}"><i class="fa fa-eye me-2"></i>Manage Payments</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-12 align-right">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('list_sale')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- page end  -->

@include('sales.actions');
@include('authentication.footer')
<script src="{{ asset('/assets/js/sales.js')}}"></script>
<script>
    $(document).ready(function() {
        getcustomer();
    });


    function getcustomer() {
        $.ajax({
            type: 'GET',
            url: "{{ url('getcustomer/') }}",
            dataType: "html",
            success: function(response) {
                $('#getCustomer').append(response);
            }
        });

    }

    search = $('#serchProduct').keyup(function() {
        var seachkey = $('input[name =searchProduct]').val();
        if (seachkey.length >= 2) {
            $.ajax({
                method: 'GET',
                url: "{{url('getProduct')}}" + "/" + seachkey,
                dataType: "html",
                success: function(response) {
                    $('#searchResult').html(response);
                }
            });
        } else {
            $('#searchResult').html('');
        }
    });

    $(document).ready(search);

    $(document).on("click", ".pick_product", function() {
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: "{{url('fetch_product')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: id
            },
            success: function(response) {
                $('#selectedProduct').append(response);
                $('input[name =searchProduct]').val('');
                $('#searchResult').html('');
                getTotalItems();
                grand_sub_total();
                calculteTotalAmount();
            },
            error: function(error) {
                console.log(error);
            }
        });

    });
    $(document).ready(function() {
        getTotalItems();
        grand_sub_total();
        calculteTotalAmount();

    });
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
                    url: 'deletepayment',
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
    add_customer = $('.add_customer').on('click', function() {
        var sale_id = $(this).attr('id');

        $('#add_customer').modal('show');
    });
    $(document).ready(add_customer);

    save_customer = $('#save_customer').on('submit', function(e) {
        e.preventDefault();

        var data = $('#save_customer').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('storecustomer')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: "success",
                    title: "Added!",
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_customer').modal('hide');
                    $('#save_customer')[0].reset();
                    $('#getCustomer').html('');
                    getcustomer();
                });

            }
        });

    });
    $(document).ready(save_customer);
</script>