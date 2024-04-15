@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales & Purchases Reports ( {{ $product->name }} - {{ $product->description }})</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="">

                    </div>
                    <div class="wordset">
                    </div>
                </div>
                <div class="page-title">
                    <h4>Product Sales Reports</h4>
                </div>

                <div class="table-responsive">
                    <table class="table ">
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
                            @if (!$salesreports->isEmpty())
                                @foreach ($salesreports as $key => $report)
                                    <tr>
                                        <td>{{ ++$key }} </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td style="font-weight: bold;">{{ $report->date }}</td>
                                        <td>{{ $sale[$report->id]->reference }}</td>
                                        <td>{{ isset($sale[$report->id]->customer) ? $sale[$report->id]->customer->name : '' }}
                                        </td>
                                        <td>{{ number_format($report->quantity) }}</td>
                                        <td>{{ number_format($report->price, 2) }}</td>
                                        <td>{{ number_format($report->total, 2) }}</td>
                                        <td>{{ $sale[$report->id]->user->name }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4>Product Purchase Reports</h4>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name </th>
                                <th>Description </th>
                                <th>Date </th>
                                <th>Reference</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total </th>
                                <th>Purchased By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$purchasereports->isEmpty())
                                @foreach ($purchasereports as $key => $report)
                                    <tr>
                                        <td>{{ ++$key }} </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td style="font-weight: bold;">{{ $report->date }}</td>
                                        <td>{{ $purchase[$report->id]->reference }}</td>
                                        <td>{{ isset($purchase[$report->id]->supplier) ? $purchase[$report->id]->supplier->name : '' }}
                                        </td>
                                        <td>{{ number_format($report->quantity) }}</td>
                                        <td>{{ number_format($report->price, 2) }}</td>
                                        <td>{{ number_format($report->total, 2) }}</td>
                                        <td>{{ $purchase[$report->id]->user->name }}</td>
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
