@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales Management</h4>
                <h6>List Sales</h6>
            </div>
            <div class="page-btn">
                <a href=" {{ route('add_sale')}}" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Sales</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
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
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Biller</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$sales->isEmpty())
                            @foreach($sales as $key => $sale)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td> {{ $sales->customer->name}}</td>
                                <td>{{ $sales->date }}</td>
                                <td>{{ $sales->reference }}</td>
                                <!-- <td><span class="badges bg-lightgreen">Completed</span></td>
                                <td><span class="badges bg-lightg">Paid</span></td> -->
                                <td><span class="badges bg-lightred">Pending</span></td>
                                        <td><span class="badges bg-lightred">Due</span></td>
                                <td>{{ $sales->grand_total }}</td>
                                <td>0.00</td>
                                <td class="text-red">100.00</td>
                                <td>{{ $sales->user->name }}</td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="sales-details.html" class="dropdown-item"><img src="assets/img/icons/eye1.svg" class="me-2" alt="img">Sale
                                                Detail</a>
                                        </li>
                                        <li>
                                            <a href="edit-sales.html" class="dropdown-item"><img src="assets/img/icons/edit.svg" class="me-2" alt="img">Edit
                                                Sale</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#showpayment"><img src="assets/img/icons/dollar-square.svg" class="me-2" alt="img">Show Payments</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createpayment"><img src="assets/img/icons/plus-circle.svg" class="me-2" alt="img">Add Payment</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><img src="assets/img/icons/printer.svg" class="me-2" alt="img">Invoice/Slip</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item confirm-text"><img src="assets/img/icons/delete1.svg" class="me-2" alt="img">Delete Sale</a>
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
<!-- page end -->

@include('authentication.footer')