@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales Management</h4>
                <h6>Sale Details</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-sales-split">
                    <h2>Sale Detail : {{$sale->reference }}</h2>
                    <ul>
                        <li>
                            <a href="{{ route('edit_sale', $sale->uuid) }}"><img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/printer.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"  class = "delete_sale" id="{{$sale->id }}"><img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img"></a>
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
                                                            Customer Info</font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$sale->customer->name }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$sale->customer->email }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$sale->customer->phone }}
                                                        </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            {{$sale->customer->address }}
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
                                                            Reference </font>
                                                    </font><br>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                            Sale Status</font>
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
                                                            {{ $sale->reference }}
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
                            @foreach($sale->sale_product as $key=> $item)
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
                                    <h5>{{ number_format($sale->grand_total,2) }}</h5>
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
@include('authentication.footer')
<script>
    $(document).ready(function() {
        $(".delete_sale").on("click", function() {
            var id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                confirmButtonClass: "btn btn-primary",
                cancelButtonClass: "btn btn-danger ml-1",
                buttonsStyling: false
            }).then(function(t) {
                if (t.value && t.dismiss !== "cancel") {
                    $.ajax({
                        type: 'POST',
                        url: "{{url('deletesale')}}",
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
                                window.location = "{{route('list_sale')}}";
                            });
                        }
                    });
                }
            });
        });
    });
</script>