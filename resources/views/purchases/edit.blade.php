@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<style>
    .pick_product {
        cursor: pointer;

    }

    input[type="number"], input[type="text"] {
        border: none;
        background-color: inherit;
    }
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4> Purchase Management</h4>
                <h6>Edit Purchase</h6>
            </div>
        </div>
        <form action="{{ route('update_purchase')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select class="select2" id="getSupplier" required name="supplier_id">
                                        <option value="{{ $purchase->supplier->id}}" selected>{{ $purchase->supplier->name}}</option>
                                        </select>
                                    </div>
                                    <input type="hidden" value="{{ $purchase->id}}" name="purchase_id">
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                        <div class="add-icon">
                                            <span class="add_supplier"><img src="{{ asset('assets/img/icons/plus1.svg')}}" alt="img"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-groupicon">
                                    <input type="date" class="form-control" value="{{ date('Y-m-d')}}" name="date">
                                    <!-- <div class="addonset">
                                    <img src="{{ asset('assets/img/icons/calendars.svg')}}" alt="img">
                                </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Reference/Invoice No.</label>
                                <input type="text" name="reference" value="{{ $purchase->reference }}" readonly>
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
                                            <h5 id="total_items">0</h5>
                                        </li>
                                        <li>
                                            <h4>Sub Total</h4>
                                            <h5 id="grand_sub_total"></h5>
                                        </li>
                                        <li>
                                            <h4>Tax</h4>
                                            <h5 id="">0</h5>
                                        </li>
                                        <li class="total">
                                            <input type="hidden" name="grand_total" value="" id="grand_sub">
                                            <h4>Grand Total</h4>
                                            <h5 id="grand_total"></h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 align-right">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('list_purchase')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- page end -->
@include('purchases.actions');
@include('authentication.footer')
<script src="{{ asset('/assets/js/purchases.js')}}"></script>
<script>
    $(document).ready(function() {
        getsupplier();
    });


    function getsupplier() {
        $.ajax({
            type: 'GET',
            url: "{{url('getsupplier')}}",
            dataType: "html",
            success: function(response) {
                $('#getSupplier').append(response);
            }
        });

    }

    search = $('#serchProduct').keyup(function() {
        var seachkey = $('input[name =searchProduct]').val();
        if (seachkey.length >= 2) {
            $.ajax({
                method: 'GET',
                url: "{{url('getPurchaseProduct')}}" + "/" + seachkey,
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
            url: "{{url('fetch_purchase')}}",
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

    add_supplier = $('.add_supplier').on('click', function() {
        var sale_id = $(this).attr('id');

        $('#add_supplier').modal('show');
    });
    $(document).ready(add_supplier);

    save_supplier = $('#save_supplier').on('submit', function(e) {
        e.preventDefault();

        var data = $('#save_supplier').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('storesupplier')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: "success",
                    title: "Added!",
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_supplier').modal('hide');
                    $('#save_supplier')[0].reset();
                    $('#getSupplier').html('');
                    getsupplier();
                });
            }
        });

    });
    $(document).ready(save_supplier);
</script>