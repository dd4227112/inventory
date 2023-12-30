@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Purchase Management</h4>
                <h6>Purchase Details</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-sales-split">
                    <h2>Purchase Detail : {{$purchase->reference }}</h2>
                    <ul>
                        <li>
                            <a href="{{ route('list_purchase') }}" class="btn btn-sm btn-primary">Back</a>
                        </li>
                        <li>
                            <a href="{{ route('edit_purchase', $purchase->uuid) }}"><img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a href="{{ route('print_purchase', $purchase->uuid ) }}"><img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/printer.svg')}}" alt="img"></a>
                        </li>
                        @if($status !='Completed')
                        <li>
                            <a href="javascript:void(0);" title="Add Payment" class="createpayment" id="{{ $purchase->uuid }}"><img src="{{ asset('assets/img/icons/dollar-square.svg')}}" alt="img"></a>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0);" class="delete_purchase" id="{{$purchase->id }}"><img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img"></a>
                        </li>

                    </ul>
                </div>
                <div class="invoice-box table-height" style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                        <tbody>
                            <tr class="top">
                                <td colspan="6" style="padding: 5px;vertical-align: top;">
                                    <table style="width: 100%;line-height: inherit;text-align: left;">
                                        <tbody>
                                            <tr>
                                                <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                                        <font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                            Supplier Info</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$purchase->supplier->name }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$purchase->supplier->email }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$purchase->supplier->phone }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$purchase->supplier->address }}
                                                        </font>
                                                    </font><br>
                                                </td>
                                                <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                                        <font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                            Company Info</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            DGT </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="9ffefbf2f6f1dffae7fef2eff3fab1fcf0f2">[email&#160;protected]</a>
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            6315996770</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            3618 Abia Martin Drive</font>
                                                    </font><br>
                                                </td>
                                                <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                                        <font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                            Invoice Info</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            Date </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            Reference </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            Purchase Status</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            Payment Status</font>
                                                    </font><br>
                                                </td>
                                                <td style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
                                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                                        <font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                            &nbsp;</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{ $purchase->date }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{ $purchase->reference }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                                            Completed</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font class="{{ $class }}" style="vertical-align: inherit;font-size: 14px;font-weight: 400;">
                                                            {{ $status }}
                                                        </font>
                                                    </font><br>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="heading " style="background: #F3F2F7;">
                                <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                    #
                                </td>
                                <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                    Product Name
                                </td>
                                <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                    QTY
                                </td>
                                <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                    Price
                                </td>
                                <td style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px;text-align:right; ">
                                    Subtotal
                                </td>
                            </tr>
                            @foreach($purchase->purchase_product as $key=> $item)
                            <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                                <td> {{++$key }}</td>
                                <td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">
                                    {{ $item->product->name }} ( {{ $item->product->code }} ) - {{ $item->product->description }}
                                </td>
                                <td style="padding: 10px;vertical-align: top; ">
                                    {{ number_format($item->quantity)}}
                                </td>
                                <td style="padding: 10px;vertical-align: top; ">
                                    {{ number_format($item->price,2)}}
                                </td>
                                <td style="padding: 10px;vertical-align: top; text-align:right;">
                                    {{ number_format($item->total, 2)}}
                                </td>
                            </tr>
                            <!-- <tr>
                                <td></td>
                            </tr> -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="total-order">
                            <ul>
                                <li class="total">
                                    <h4>Grand Total</h4>
                                    <h5>{{ number_format($purchase->grand_total,2) }}</h5>
                                </li>
                                <li class="total">
                                    <h4>Paid </h4>
                                    <h5>{{ number_format($paid,2) }}</h5>
                                </li>
                                <li class="total">
                                    <h4>Balance </h4>
                                    <h5>{{ number_format($balance,2) }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page end  -->

<!-- add payment -->
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
@include('purchases.actions');
@include('authentication.footer')
<script>
    $(document).ready(function() {
        $(".delete_purchase").on("click", function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this purchase!",
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
                        url: "{{url('deletepurchase')}}",
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
                                window.location = "{{route('list_purchase')}}";
                            });
                        }
                    });
                }
            });
        });
    });
    // add payment modal
add_payment = $('.createpayment').click(function () {
    var uuid = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: "{{url('getpayment')}}",
        dataType:'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            uuid: uuid
        },
        success: function (response) {
            $('#purchase_amount').val(response.balance);
            $('#amount').val(response.balance);
            $('#supplier').val(response.supplier);
            $('#purchase_id').val(response.purchase_id);
            $('#createpayment').modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });

});
$(document).ready(add_payment);
</script>