<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Simple invoice page - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/assets/invoice/css/bootstrapcdn.min.css')}}" rel="stylesheet">
    <style type="text/css">
        body {
            margin-top: 20px;
            background: #eee;
        }




        /**    17. Panel
 *************************************************** **/
        /* pannel */
        .panel {
            position: relative;

            background: transparent;

            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;

            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }

        .panel.fullscreen .accordion .panel-body,
        .panel.fullscreen .panel-group .panel-body {
            position: relative !important;
            top: auto !important;
            left: auto !important;
            right: auto !important;
            bottom: auto !important;
        }

        .panel.fullscreen .panel-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }


        .panel>.panel-heading {
            text-transform: uppercase;

            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .panel>.panel-heading small {
            text-transform: none;
        }

        .panel>.panel-heading strong {
            font-family: Arial, Helvetica, Sans-Serif;
        }

        .panel>.panel-heading .buttons {
            display: inline-block;
            margin-top: -3px;
            margin-right: -8px;
        }

        .panel-default>.panel-heading {
            padding: 15px 15px;
            background: #fff;
        }

        .panel-default>.panel-heading small {
            color: #9E9E9E;
            font-size: 12px;
            font-weight: 300;
        }

        .panel-clean {
            border: 1px solid #ddd;
            border-bottom: 3px solid #ddd;

            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .panel-clean>.panel-heading {
            padding: 11px 15px;
            background: #fff !important;
            color: #000;
            border-bottom: #eee 1px solid;
        }

        .panel>.panel-heading .btn {
            margin-bottom: 0 !important;
        }

        .panel>.panel-heading .progress {
            background-color: #ddd;
        }

        .panel>.panel-heading .pagination {
            margin: -5px;
        }

        .panel-default {
            border: 0;
        }

        .panel-light {
            border: rgba(0, 0, 0, 0.1) 1px solid;
        }

        .panel-light>.panel-heading {
            padding: 11px 15px;
            background: transaprent;
            border-bottom: rgba(0, 0, 0, 0.1) 1px solid;
        }

        .panel-heading a.opt>.fa {
            display: inline-block;
            font-size: 14px;
            font-style: normal;
            font-weight: normal;
            margin-right: 2px;
            padding: 5px;
            position: relative;
            text-align: right;
            top: -1px;
        }

        .panel-heading>label>.form-control {
            display: inline-block;
            margin-top: -8px;
            margin-right: 0;
            height: 30px;
            padding: 0 15px;
        }

        .panel-heading ul.options>li>a {
            color: #999;
        }

        .panel-heading ul.options>li>a:hover {
            color: #333;
        }

        .panel-title a {
            text-decoration: none;
            display: block;
            color: #333;
        }

        .panel-body.panel-row {
            padding: 8px;
        }

        .panel-footer {
            font-size: 12px;
            border-top: rgba(0, 0, 0, 0.02) 1px solid;
            background-color: rgba(0255, 255, 255, 1);

            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>
    <div class="container bootstrap snippets bootdey">
        <p></p>
        <h4 class="text-center">{{ $title }}</h4>
        <h5 class="text-center">Reference: {{$reference }}</h5>
        <h5 class="text-center">Date: {{$date }}</h5>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="nomargin" style="width: 100%; padding: 10px;">
                        <tr>
                            <td class="text-left">
                                <h4><strong>To:</strong> </h4>

                                {{$purchase->supplier->name}} <br>
                                {{$purchase->supplier->address}} <br>
                                {{$purchase->supplier->email}}<br>
                                {{$purchase->supplier->phone}}<br>

                            </td>
                            <td class="text-right">
                                <h4><strong>From:</strong></h4>
                                {!! site_address($purchase->shop_id) !!}
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($show_payment == 'yes')
                                <ul class="list-unstyled">
                                    <li>Paid To: &nbsp;&nbsp;&nbsp;<strong> {{$purchase->supplier->name }} - {{$purchase->supplier->phone }}</strong> </li>
                                    <li>Amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>TZS {{ number_format($payment->amount,2) }}/=</strong></li>
                                    <li>Amount in Word: &nbsp;&nbsp;&nbsp;<strong>Tanzania Shilings {{ $in_words}} Only.</strong></li>
                                    <li>Payment Reference:&nbsp;&nbsp;&nbsp;<strong> {{ $payment->reference }}</strong></li>
                                    <li>Payment Date: &nbsp;&nbsp;&nbsp;<strong> {{ $payment->date }}</strong></li>
                                    {!! $purchase_reference !!}
                                    <li>Payment For: &nbsp;&nbsp;&nbsp;<strong> Being Payment for following products below:-</strong></li>

                                </ul>
                                @endif
                            </td>
                            <td></td>

                        </tr>

                    </table>
                </div>


                <div class="table-responsive">
                    <table class="table nomargin">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th> Price</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->purchase_product as $key =>$item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>
                                    <strong>{{ $item->product->name }} - {{ $item->product->description }}</strong>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price,2) }}</td>
                                <td class="text-right">{{ number_format($item->total,2)}}</td>

                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="3"></td>
                                <td class="text-left">
                                    <!-- <div>
                                    <h4><strong>Contact</strong> Details</h4>
                                    <address>
                                        PO Box 21132 <br>
                                        Vivas 2355 Australia<br>
                                        Phone: 1-800-565-2390 <br>
                                        Fax: 1-800-565-2390 <br>
                                        Email:<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="1a696f6a6a75686e5a63756f68747b777f34797577">[email&#160;protected]</a>
                                    </address>
                                </div> -->
                                </td>

                                <td class="text-right">
                                    <div>
                                        <ul class="list-unstyled">
                                            <li><strong> Grand Total:</strong> {{number_format($purchase->grand_total, 2) }}</li>
                                            <li><strong>Total Paid:</strong> {{ number_format($paid, 2) }} </li>
                                            <li><strong>Balance</strong> {{ number_format($balance, 2)  }}</li>

                                        </ul>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table nomargin" style="width: 100%;">
                        <tr>
                            <td class="text-left">
                                <div>
                                    <ul class="list-unstyled">
                                        <li><strong> {{$heading}}</strong><br> {{$name }}</li>
                                        <br>
                                        <li> .....................</li>

                                        <li><i>{{ $date }}</i></li>

                                    </ul>

                                </div>
                            </td>
                            <td class="text-right">
                                <div>
                                    @if(isset($qr))
                                    {!! $qr !!}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>