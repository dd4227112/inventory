@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Reports</h4>
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
                                <th>Description</th>
                                <th>Unit </th>
                                <th>Category</th>
                                <th>Cost</th>
                                <th>Price</th>
                                <th>Purchase Qty</th>
                                <th>Sold Qty</th>
                                <th>Balance Qty</th>
                                <th>Created By</th>
                                <th>View More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $product->name}} ({{ $product->code}})</td>
                                <td>{{ $product->description}}</td>
                                <td>{{ $product->unit->name}}</td>
                                <td>{{ $product->category->name}}</td>
                                <td>{{ number_format($product->cost, 2)}}</td>
                                <td>{{ number_format($product->price, 2)}}</td>
                                <td>{{ number_format($summary[$product->id]['purchased'])}}</td>
                                <td>{{ number_format($summary[$product->id]['sold'])}}</td>
                                <td>{{ number_format($summary[$product->id]['balance'])}}</td>
                                <td>{{ $product->user->name}}</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('productSale',   $product->uuid) }}" class="dropdown-item">View Sale
                                                Detail</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('productPurchase', $product->uuid) }}" class="dropdown-item">View Purchase
                                                Details</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('combinedProduct', $product->uuid) }}" class="dropdown-item">View Combined
                                                </a>
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

<!-- page content end -->

@include('authentication.footer')