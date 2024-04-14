@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Management</h4>
                <h6>List Products</h6> 
            </div>
            @if(can_access('add_product'))
            <div class="page-btn">
                <a href="{{route('add_product')}}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-2">Add Product</a>
            </div>
            @endif
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
                </div>

                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name </th>
                                <th>Description</th>
                                <th>Brand</th>
                                <th>Unit </th>
                                <th>Quantity</th>
                                <th>Purchase Cost</th>
                                <th> Selling Price</th>
                                <th>Shop</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $product->name}}</td>
                                <td>{{ $product->description}}</td>
                                <td>{{ $product->category->name}}</td>
                                <td>{{ $product->unit->name}}</td>
                                <td>{{ number_format(product_balance($product->id)['balance'])}}</td>
                                <td>{{ number_format($product->cost, 2)}}</td>
                                <td>{{ number_format($product->price, 2)}}</td>
                                <td>{{ $product->shop->name}}</td>
                                <td>{{ $product->user->name}}</td>
                                <td>
                                @if(can_access('edit_product'))
                                    <a class="me-3" href="{{route('edit_product', $product->uuid) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    @endif
                                    @if(can_access('delete_product'))
                                    <a class="me-3 deleteProduct" id="{{$product->id }}" href="javascript:void(0);">
                                        <img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img">
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

<!-- page content end -->

@include('authentication.footer')
<script>
      $(document).on("click", ".deleteProduct", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this Product!",
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
                    url: "{{url('deleteproduct')}}",
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
</script>