<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{

    protected $data;

    public function index()
    {
        $sales = sale::where('shop_id', session('shop_id'))->get();
        $this->data['sales'] = $sales;
        $payment = [];
        if (!$sales->isEmpty()) {
            foreach ($sales as $key => $sale) {
                $payment[$sale->id] =  $sale->payment->sum('amount');
            }
        }
        $this->data['payments'] = $payment;
        return view('sales.index', $this->data);
    }

    public function  addsale()
    {
        $this->data['shops'] = Shop::all();
        return view('sales.add', $this->data);
    }
    public function store(Request $request)
    {

        $data = [
            'reference' => $request->reference,
            'grand_total' => remove_comma($request->grand_total),
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'shop_id' => session('shop_id'),
            'customer_id' => $request->customer_id,
            'status' => 1,
        ];
        // add sales record
        $sale = Sale::create($data);

        $size  = sizeof($request->product_id);
        for ($i = 0; $i < $size; $i++) {
            $product = [
                'date' => $request->date,
                'quantity' => $request->quantity[$i],
                'product_id' => $request->product_id[$i],
                'price' => $request->price[$i],
                'total' => ($request->quantity[$i] * $request->price[$i]),
                'sale_id' => $sale->id,
            ];
            // add sales products
            SaleProduct::create($product);
        }
        // add payement if posted
        if ($request->payment_amount != ' ' && $request->payment_amount  > 0) {
            if (remove_comma($request->payment_amount) > remove_comma($request->grand_total)) {
                return redirect()->route('list_sale')->with('warning', "Sale Added but Payment not added because greater amount posted");
            }
            $data = [
                'amount' => remove_comma($request->payment_amount),
                'reference' => $request->payment_reference,
                'date' => $request->date,
                'sale_id' => $sale->id,
                'user_id' => Auth::user()->id,
                'status' => 1,
                'payment_method' => $request->payment_method,
                'description' => $request->description,

            ];
            Payment::create($data);
        }
        return redirect()->route('view_sale', $sale->uuid)->with('success', "Sale Added Successfully");
    }
    public function salepayment(Request $request)
    {
        $uuid = $request->uuid;
        $sale = Sale::where('uuid', $uuid)->first();
        if (!empty($sale)) {
            $data = [
                'customer' => $sale->customer->name,
                'sale_id' => $sale->id,
                'balance' => number_format($sale->grand_total - $sale->payment->sum('amount'), 2),
            ];
        } else {
            $data = [
                'customer' => '',
                'sale_id' => '',
                'balance' => '',
            ];
        }
        echo json_encode($data);
    }
    public function savepayment(Request $request)
    {
        $data = $request->except('_token');
        if (remove_comma($request->amount) > remove_comma($request->balance)) {
            return redirect()->back()->with('warning', "Can't accept greater amount than the current balance of " . $request->balance);
        }
        $amount = remove_comma($request->amount);
        $data['amount'] = $amount;
        $other_data = [
            'user_id' => Auth::user()->id,
            'status' => 1,
        ];
        $data = $data +  $other_data;
        //dd($data);

        if (Payment::create($data)) {
            return redirect()->route('list_sale')->with('success', "Payment Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to Add Payment");
        }
    }
    public function viewsale($uuid)
    {
        $sale = Sale::where('uuid', $uuid)->first();
        if (empty($sale)) {
            abort(403);
        }
        $payment_status = sale_payment_status("Sale", $sale->id, $sale->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $sale->grand_total - $payment_status['amount'];
        $this->data['sale'] = $sale;
        return view('sales.details', $this->data);
    }
    public function destroy(Request $request)
    {
        $sale = Sale::find($request->id);
        if ($sale->delete()) {
            $sale->update(['deleted_by' => Auth::user()->id]);
            SaleProduct::where('sale_id', $request->id)->delete();
            Payment::where('sale_id', $request->id)->update(['deleted_by' => Auth::user()->id]);
            Payment::where('sale_id', $request->id)->delete();

            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }
    public function edit($uuid)
    {
        $sale = Sale::where('uuid', $uuid)->first();
        if (empty($sale)) {
            abort(403);
        }
        $sale_items = SaleProduct::where('sale_id', $sale->id)->get();
        //$payment_count = Payment::where('sale_id', $sale->id)->count();
        // we have multiple payment records, we set payment = multiple, then will edit payment in other way
        // if ($payment_count > 1) {
        //     $this->data['payment'] = 'multiple';
        // } else {
        //     $payment = Payment::where('sale_id', $sale->id)->first();
        //     if (!empty($payment)) {
        //         $this->data['payment'] =  $payment;
        //     }
        // }
        // we removed edit payment record during edit sale because payment has its own edit method
        $this->data['sale'] = $sale;
        $this->data['items'] = $sale_items;
        return view('sales.edit', $this->data);
    }
    public function updatesale(Request $request)
    {
        $sale_id = $request->sale_id;
        $data = [
            'reference' => $request->reference,
            'grand_total' => str_replace(',', '', $request->grand_total),
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'shop_id' => session('shop_id'),
            'customer_id' => $request->customer_id,
            'status' => 1,
        ];
        $sale = Sale::find($sale_id);
        $sale->update($data);
        SaleProduct::where('sale_id', $sale_id)->delete();
        $size  = sizeof($request->product_id);
        for ($i = 0; $i < $size; $i++) {
            $product = [
                'date' => $request->date,
                'quantity' => $request->quantity[$i],
                'product_id' => $request->product_id[$i],
                'price' => $request->price[$i],
                'total' => ($request->quantity[$i] * $request->price[$i]),
                'sale_id' => $sale_id,
            ];
            SaleProduct::create($product);
        }
        return redirect()->route('view_sale', $sale->uuid)->with('success', "Sale Updated Successfully");
    }
    public function singleSalePayment(Request $request)
    {
        $id  = $request->id;
        $sale = Sale::find($id);
        $payments = Payment::where('sale_id', $request->id)->get();
        $html = " ";
        if (!$payments->isEmpty()) {
            foreach ($payments as $key => $payment) {
                $html .=  "<tr class='bor-b1'>";
                $html  .= "<td>" . $payment->date . "</td>";
                $html  .= "<td>" . $sale->customer->name . "</td>";
                $html  .= "<td>" . $payment->reference . "</td>";
                $html  .= "<td>" . number_format($payment->amount, 2) . " </td>";
                $html  .= "<td>Cash</td>";
                $html  .= "<td>" . $payment->description . " </td>";
                $html  .= "<td>" . $payment->user->name . " </td>";
                $html  .= "<td>";
                if (can_access('print_sale_payment')) {
                    $html  .= "<a class='me-2' href='" . route('sale_payment_receipt', $payment->uuid) . "'>
                        <img src='" . url('assets/img/icons/printer.svg') . "' alt='img'>
                    </a>";
                }
                if (can_access('edit_sale_payment')) {
                    $html  .= "<a class='me-2 getPayment' id = '" . $payment->id . "' href='javascript:void(0);' 
                        data-bs-dismiss='modal'>
                        <img src= '" . url('assets/img/icons/edit.svg') . "' alt='img'>
                    </a>";
                }
                if (can_access('delete_sale_payment')) {
                    $html  .= " <a class='me-2 deletePayment' id = '" . $payment->id . "' href='javascript:void(0);'>
                        <img src='" . url('assets/img/icons/delete.svg') . "' alt='img'>
                    </a>";
                }
                $html  .= "</td>
            </tr>";
            }
        }
        echo $html;
    }
    public function print($uuid)
    {
        $sale = Sale::where('uuid', $uuid)->first();
        if (empty($sale)) {
            abort(403);
        }
        $payment_status = sale_payment_status("Sale", $sale->id, $sale->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $sale->grand_total - $payment_status['amount'];
        $this->data['sale'] = $sale;
        $this->data['title'] = 'SALES INVOICE';
        $this->data['reference'] =  $sale->reference;
        $this->data['sale_reference']  = '';
        $this->data['date'] = $sale->date;
        $this->data['heading'] = "Created By:";

        $this->data['name'] = $sale->user->name;



        // check the number of payment per sale
        $count = Payment::where('sale_id', $sale->id)->count();
        if ($count > 1) {
            $this->data['show_payment'] = 'no';
            $this->data['payment'] = '';
            $this->data['in_words'] = '';
        } else {
            $payment = Payment::where('sale_id', $sale->id)->first();
            $this->data['show_payment'] = 'no';
            if (!empty($payment)) {
                $this->data['show_payment'] = 'yes';
                $this->data['payment'] = $payment;
                $this->data['in_words'] = number_to_words($payment->amount);
                $this->data['qr'] = generateQr($payment->id, 'pdf', 'previewpayment');
            }
        }

        $pdf = PDF::loadView('sales.invoice', $this->data);
        $pdf->setPaper('A4');
        // return $pdf->stream('tutsmake.pdf', array('Attachment' => false));
        return $pdf->download('sales_' . $sale->reference . '.pdf');
    }
}
