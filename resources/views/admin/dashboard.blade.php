@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/dash1.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>TZS <span>{{ number_format($total_purchases,2)}}</span></h5>
                        <h6>Total Purchases </h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/dash2.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>TZS <span>{{ number_format($total_sales,2)}}</span></h5>
                        <h6>Total Sales</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/dash3.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>TZS <span>{{ number_format($today_sales,2)}}</span></h5>
                        <h6>Today's Sales </h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/dash4.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>TZS <span>{{ number_format($today_purchases,2)}}</span></h5>
                        <h6>Today's Purchases </h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/product.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><span>{{ number_format($all_product)}}</span></h5>
                        <h6>All Products</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
                <div class="dash-widget dash3">
                    <div class="dash-widgetimg">
                        <span><img src="{{ asset('assets/img/icons/product.svg')}}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5> <span>{{ number_format($in_stock)}} / {{ number_format($out_stock)}}</span></h5>
                        <h6>In-stock/Out-Stock</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ number_format($customers)}}</h4>
                        <h5>Customers</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ number_format($suppliers)}}</h4>
                        <h5>Suppliers</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ number_format($number_purchases)}}</h4>
                        <h5>Purchase Invoice</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4>{{ number_format($number_sales)}}</h4>
                        <h5>Sales Invoice</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Purchases vs Sales</h5>
                        <div class="graph-sets">
                            <ul>
                                <li>
                                    <span>Sales</span>
                                </li>
                                <li>
                                    <span>Purchase</span>
                                </li>
                            </ul>
                            <!-- <div class="dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    2022 <img src="{{ asset('assets/img/icons/dropdown.svg')}}" alt="img" class="ms-2">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2022</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2021</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2020</a>
                                    </li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="purchase_sales" class="chart-set"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Most Sold Products</h4>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="{{ route('list_product')}}" class="dropdown-item">List Product</a>
                                </li>
                                <li>
                                    <a href="{{ route('add_product')}}" class="dropdown-item"> Add Product</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Products</th>
                                        <th>Unit</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$most_solds->isEmpty())
                                    @foreach($most_solds as $i=> $most_sold)
                                    <tr>
                                        <td>{{ ++$i}}</td>
                                        <td class="productimgname">

                                            {{$most_sold->name }} - {{ $most_sold->description}}
                                        </td>
                                        <td>{{$most_sold->unit->name }}</td>
                                        <td>{{$most_sold->category->name }}</td>
                                        <td>TZS {{number_format($most_sold->price ,2)}}</td>
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
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0"> 5 Recent Sales</h4>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="{{ route('list_sale')}}" class="dropdown-item">List Sales</a>
                                </li>
                                <li>
                                    <a href="{{ route('add_sale')}}" class="dropdown-item"> Add Sale</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Reference</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Biller</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$sales->isEmpty())
                                    @foreach($sales as $key => $sale)
                                    <tr>
                                        <td>
                                            {{ ++$key}}
                                        </td>
                                        <td>{{ $sale->date }}</td>
                                        <td> {{ $sale->customer->name}}</td>
                                        <td>{{ $sale->reference }}</td>
                                        <td style="text-align: right;">{{ number_format($sale->grand_total,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($payments[$sale->id],2) }}</td>
                                        <td style="text-align: right;">{{ number_format(($sale->grand_total - $payments[$sale->id] ),2) }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0"> 5 Recent Purchases</h4>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="{{ route('list_purchase')}}" class="dropdown-item">List Purchase</a>
                                </li>
                                <li>
                                    <a href="{{ route('add_purchase')}}" class="dropdown-item"> Add Purchase</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table datatable ">
                                <thead>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Supplier Name</th>
                                    <th>Reference</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Biller</th>
                                </thead>
                                <tbody>
                                    @if(!$purchases->isEmpty())
                                    @foreach($purchases as $key => $purchase)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $purchase->date }}</td>
                                        <td> {{ $purchase->supplier->name}}</td>
                                        <td>{{ $purchase->reference }}</td>
                                        <td style="text-align: right;">{{ number_format($purchase->grand_total,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($purchase_payment[$purchase->id], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format(($purchase->grand_total - $purchase_payment[$purchase->id]), 2) }}</td>
                                        <td>{{ $purchase->user->name }}</td>
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
    </div>
</div>


<!-- page content end -->

@include('authentication.footer')
<script>
    $(document).ready(function() {

        if ($('#purchase_sales').length > 0) {
            var sCol = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'flat'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                series: [{
                    name: 'Purchases',
                    data: [<?= $purchases_chart ?>]
                }, {
                    name: 'Sales',
                    data: [<?= $sales_chart ?>]
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                yaxis: {
                    title: {
                        text: 'TZS(Tanzania Shillings)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "TZS " + val.toLocaleString('en-US')
                        }
                    }
                }
            }
            var chart = new ApexCharts(document.querySelector("#purchase_sales"), sCol);
            chart.render();
        }
    });
</script>