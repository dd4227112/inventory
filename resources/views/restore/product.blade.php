@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Deleted Products </h4>
                <h6>Restore/Permanently delete Product</h6>
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
                                <th>Code </th>
                                <th>Name </th>
                                <th>Description</th>
                                <th>Unit </th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Price</th>
                                <th>Shop</th>
                                <th>Deleted By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $product->code}}</td>
                                <td>{{ $product->name}}</td>
                                <td>{{ $product->description}}</td>
                                <td>{{ $product->unit->name}}</td>
                                <td>{{ $product->category->name}}</td>
                                <td>{{ number_format(product_balance($product->id)['balance'])}}</td>
                                <td>{{ number_format($product->cost, 2)}}</td>
                                <td>{{ number_format($product->price, 2)}}</td>
                                <td>{{ $product->shop->name}}</td>
                                <td>{{ $product->deletedBy->name}}</td>
                                <td>
                                    @if(can_access('edit_product'))
                                    <a class="me-3" href="{{route('edit_product', $product->uuid) }}">
                                        <i class="fa fa-undo text-success"></i>
                                    </a>
                                    @endif
                                    @if(can_access('delete_product'))
                                    <a class="me-3 deleteProduct" id="{{$product->id }}" href="javascript:void(0);">
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