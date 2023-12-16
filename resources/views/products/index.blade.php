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
            <div class="page-btn">
                <a href="{{route('add_product')}}" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-2">Add Product</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
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
                                <th>Created By</th>
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
                                <td>{{ number_format($product->quantity, 1)}}</td>
                                <td>{{ number_format($product->cost, 2)}}</td>
                                <td>{{ number_format($product->price, 2)}}</td>
                                <td>{{ $product->shop->name}}</td>
                                <td>{{ $product->user->name}}</td>
                                <td>
                                    <a class="me-3" href="editproduct.html">
                                        <img src="assets/img/icons/edit.svg" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" id="{{$product->id }}" href="javascript:void(0);">
                                        <img src="assets/img/icons/delete.svg" alt="img">
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