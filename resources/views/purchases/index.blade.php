@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchases Management</h4>
                <h6>List Purchases</h6>
            </div>
            <div class="page-btn">
                <a href=" {{ route('add_purchase')}}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">Add purchases</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
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
                                <th>Date</th>
                                <th>Supplier Name</th>
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
                                    <td><span class="badges bg-lightgreen">Completed</span></td>
                                    @if($purchase->grand_total == $payments[$purchase->id] )
                                    <td><span class="badges bg-lightgreen">Completed</span></td>
                                    @elseif(( $payments[$purchase->id] < $purchase->grand_total) && ($payments[$purchase->id] > 0))
                                        <td> <span class="badges bg-lightyellow">Partial</span></td>
                                        @else
                                        <td><span class="badges bg-lightred">Pending</span></td>
                                        @endif
                                        <td style="text-align: right;">{{ number_format($purchase->grand_total,2) }}</td>
                                        <td style="text-align: right;">{{ number_format($payments[$purchase->id], 2) }}</td>
                                        <td style="text-align: right;">{{ number_format(($purchase->grand_total - $payments[$purchase->id]), 2) }}</td>

                                        <td>{{ $purchase->user->name }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="purchases-details.html" class="dropdown-item"><img src="{{ asset('assets/img/icons/eye1.svg')}}" class="me-2" alt="img">purchase
                                                        Detail</a>
                                                </li>
                                                @if($payments[$purchase->id] == 0)
                                                <li>
                                                    <a href="edit-purchases.html" class="dropdown-item"><img src="{{ asset('assets/img/icons/edit.svg')}}" class="me-2" alt="img">Edit
                                                        purchase</a>
                                                </li>
                                                @endif
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#showpayment"><img src="{{ asset('assets/img/icons/dollar-square.svg')}}" class="me-2" alt="img">Show Payments</a>
                                                </li>
                                                @if(($payments[$purchase->id] < $purchase->grand_total))
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item createpayment" id="{{ $purchase->uuid }}"><img src="{{ asset('assets/img/icons/plus-circle.svg')}}" class="me-2" alt="img">Add Payment</a>
                                                    </li>
                                                    @endif
                                                    @if($payments[$purchase->id] !=0)
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item"><img src="{{ asset('assets/img/icons/printer.svg')}}" class="me-2" alt="img">Invoice/Slip</a>
                                                    </li>
                                                    @endif
                                                    @if($payments[$purchase->id] == 0)
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item confirm-text"><img src="{{ asset('assets/img/icons/delete1.svg')}}" class="me-2" alt="img">Delete purchase</a>
                                                    </li>
                                                    @endif
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

<!-- add payemnt modal -->
<div class="modal fade" id="createpayment" tabindex="-1" aria-labelledby="createpayment" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('store_payment') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <div class="input-groupicon">
                                    <input type="text" value="" id="supplier" readonly class="datetimepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-groupicon">
                                    <input type="text" required value="{{date('Y-m-d')}}" name="date" class="">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Reference</label>
                                <input type="text" name="reference" readonly value="{{reference() }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" id="purchase_amount" name="balance" readonly value="0.00">
                                <input type="hidden" id="purchase_id" name="purchase_id" value="0.00">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Paying Amount</label>
                                <input type="text" value="0.00" id="amount" required name="amount" min="1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select class="select" name="payment_method">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank</option>
                                    <option value="3">Credit Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label>Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-submit">Submit</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('authentication.footer')
<script src="{{ asset('/assets/js/purchases.js')}}"></script>