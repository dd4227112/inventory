@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Sales Reports ( {{$product->name }} - {{$product->description }})</h4>
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
                                <th>Description </th>
                                <th>Date </th>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total </th>
                                <th>Sold By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$reports->isEmpty())
                            @foreach($reports as $key => $report)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $product->name}} ({{ $product->code}})</td>
                                <td>{{ $product->description}}</td>
                                <td>{{ $report->date}}</td>
                                <td>{{ $sale[$report->id]->reference}}</td>
                                <td>{{ $sale[$report->id]->customer->name}}</td>
                                <td>{{ number_format($report->quantity)}}</td>
                                <td>{{ number_format($report->price, 2)}}</td>
                                <td>{{ number_format($report->total,2)}}</td>
                                <td>{{ $sale[$report->id]->user->name}}</td>
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