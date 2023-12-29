@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales & Purchases Reports ( {{$product->name }} - {{$product->description }})</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="">
                        
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
                <div class="page-title">
                    <h4>Product Sales Reports</h4>
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
                            @if(!$salesreports->isEmpty())
                            @foreach($salesreports as $key => $report)
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

        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4>Product Sales Reports</h4>
                </div>
                <div class="table-responsive">
                    <table class="table filterPurchase">
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
                            @if(!$purchasereports->isEmpty())
                            @foreach($purchasereports as $key => $report)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $product->name}} ({{ $product->code}})</td>
                                <td>{{ $product->description}}</td>
                                <td>{{ $report->date}}</td>
                                <td>{{ $purchase[$report->id]->reference}}</td>
                                <td>{{ $purchase[$report->id]->supplier->name}}</td>
                                <td>{{ number_format($report->quantity)}}</td>
                                <td>{{ number_format($report->price, 2)}}</td>
                                <td>{{ number_format($report->total,2)}}</td>
                                <td>{{ $purchase[$report->id]->user->name}}</td>
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
    $(document).ready(function() {

        // if ($('.filterPurchase').length > 0) {
        //     $('.filterPurchase').DataTable({
        //         "bFilter": true,
        //         "sDom": 'fBtlpi',
        //         'pagingType': 'numbers',
        //         "ordering": true,
        //         "language": {
        //             search: ' ',
        //             sLengthMenu: '_MENU_',
        //             searchPlaceholder: "Search...",
        //             info: "_START_ - _END_ of _TOTAL_ items",
        //         },
        //         initComplete: (settings, json) => {
        //             $('.dataTables_filter').appendTo('#tableSearch');
        //             $('.dataTables_filter').appendTo('.search-filter');
        //         },
        //     });
        // }
    });
</script>