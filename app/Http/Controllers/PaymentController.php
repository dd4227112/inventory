<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    protected $data;
    public function getpayment(Request $request)
    {
        $uuid = $request->uuid;
        $purchase = Purchase::where('uuid', $uuid)->first();
        if (!empty($purchase)) {
            $data = [
                'supplier' => $purchase->supplier->name,
                'purchase_id' => $purchase->id,
                'balance' => number_format($purchase->grand_total - $purchase->payment->sum('amount'), 2),
            ];
        } else {
            $data = [
                'supplier' => '',
                'purchase_id' => '',
                'balance' => '',
            ];
        }
        echo json_encode($data);
    }

    public function store(Request $request)
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


        if (Payment::create($data)) {
            return redirect()->route('list_purchase')->with('success', "Payment Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to Add Payment");
        }
    }

    public function deletepayment(Request $request)
    {
        $payment = Payment::find($request->id);
        if ($payment->delete()) {
            $payment->update(['deleted_by'=>Auth::user()->id]);
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }
    public function getSinglePayment(Request $request)
    {
        $id = $request->id;
        $payment = Payment::find($id);
        $sale = Sale::find($payment->sale_id);
        if (!empty($payment) && !empty($sale)) {

            $data = [
                'customer' => $sale->customer->name,
                'payment_id' => $payment->id,
                'amount' => number_format($payment->amount, 2),
                'date' => $payment->date,
                'reference' => $payment->reference,
                'description' => $payment->description,
                'balance' => number_format($sale->grand_total - $sale->payment->sum('amount'), 2),


            ];
        } else {
            $data = [
                'customer' => '',
                'payment_id' => '',
                'amount' => '',
                'date' => '',
                'reference' => '',
                'description' => '',
                'balance' => '',
            ];
        }
        echo json_encode($data);
    }
    public function updatepayment(Request  $req)
    {
        $data = $req->except(['_token', 'payment_id']);
        $payment = Payment::find($req->payment_id);
        $data['amount'] = remove_comma($req->amount);
        if (remove_comma($req->amount) > (remove_comma($req->balance) + $payment->amount)) {
            return redirect()->back()->with('warning', "Can't accept greater amount than the current balance of " . remove_comma($req->balance));
        }
        if (!empty($payment)) {
            if ($payment->update($data)) {
                return redirect()->route('list_sale')->with('success', "Payment Updates Successfully");
            } else {
                return redirect()->back()->with('error', "Failed to Update Payment");
            }
        } else {
            return redirect()->back()->with('error', "Payment details not found");
        }
    }
    public function salepaymentreceipt($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();
        if (empty($payment)) {
            abort(403);
        }
        $sale = Sale::find($payment->sale_id);
        $payment_status = sale_payment_status("Sale", $sale->id, $sale->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $sale->grand_total - $payment_status['amount'];
        $this->data['sale'] = $sale;
        $this->data['title'] = 'PAYMENT RECEIPT';
        $this->data['reference'] =  $payment->reference;
        $this->data['payment'] = $payment;
        $this->data['in_words'] = number_to_words($payment->amount);
        $this->data['show_payment'] = 'yes';
        $this->data['sale_reference']  = "<li>Sales Reference: &nbsp;&nbsp;&nbsp;<strong>" . $sale->reference . "</strong></li>";
        $this->data['date'] = $payment->date;
        $this->data['heading'] = "Received By:";
        $this->data['name'] = $payment->user->name;
        $this->data['qr'] = generateQr($payment->id, 'pdf', 'previewpayment');




        $pdf = PDF::loadView('sales.invoice', $this->data);
        $pdf->setPaper('A4');
        // return $pdf->stream('tutsmake.pdf', array('Attachment' => false));
        return $pdf->download('receipt_' . $payment->reference . '.pdf');
    }
    public function previewpayment()
    {
        $code = request('payment');
        $payment_id = substr($code, 0, -3);
        $id = decrypt_code($payment_id);
        $payment = Payment::where('id', $id)->first();
        if (empty($payment)) {
            abort(403);
        }
        $sale = Sale::find($payment->sale_id);
        $payment_status = sale_payment_status("Sale", $sale->id, $sale->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $sale->grand_total - $payment_status['amount'];
        $this->data['sale'] = $sale;
        $this->data['title'] = 'PAYMENT RECEIPT';
        $this->data['reference'] =  $payment->reference;
        $this->data['payment'] = $payment;
        $this->data['in_words'] = number_to_words($payment->amount);
        $this->data['show_payment'] = 'yes';
        $this->data['sale_reference']  = "<li>Sales Reference: &nbsp;&nbsp;&nbsp;<strong>" . $sale->reference . "</strong></li>";
        $this->data['date'] = $payment->date;
        $this->data['heading'] = "Received By:";
        $this->data['name'] = $payment->user->name;
        $this->data['qr'] = generateQr($payment->id, '', 'previewpayment');
        return view('sales.preview', $this->data);
    }
    public function deletepurchasepayment(Request $request)
    {
        $payment = Payment::find($request->id);
        if ($payment->delete()) {
            $payment->update(['deleted_by'=>Auth::user()->id]);
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }

    public function getSinglePurchasePayment(Request $request)
    {
        $id = $request->id;
        $payment = Payment::find($id);
        $purchase = Purchase::find($payment->purchase_id);
        if (!empty($payment) && !empty($purchase)) {

            $data = [
                'supplier' => $purchase->supplier->name,
                'payment_id' => $payment->id,
                'amount' => number_format($payment->amount, 2),
                'date' => $payment->date,
                'reference' => $payment->reference,
                'description' => $payment->description,
                'balance' => number_format($purchase->grand_total - $purchase->payment->sum('amount'), 2),


            ];
        } else {
            $data = [
                'supplier' => '',
                'payment_id' => '',
                'amount' => '',
                'date' => '',
                'reference' => '',
                'description' => '',
                'balance' => '',
            ];
        }
        echo json_encode($data);
    }

    public function updatePurchasePayment(Request  $req)
    {
        $data = $req->except(['_token', 'payment_id']);
        $payment = Payment::find($req->payment_id);
        $data['amount'] = remove_comma($req->amount);
        if (remove_comma($req->amount) > (remove_comma($req->balance) + $payment->amount)) {
            return redirect()->back()->with('warning', "Can't accept greater amount than the current balance of " . remove_comma($req->balance));
        }
        if (!empty($payment)) {
            if ($payment->update($data)) {
                return redirect()->route('list_purchase')->with('success', "Payment Updates Successfully");
            } else {
                return redirect()->back()->with('error', "Failed to Update Payment");
            }
        } else {
            return redirect()->back()->with('error', "Payment details not found");
        }
    }

    public function purchasepaymentreceipt($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();
        if (empty($payment)) {
            abort(403);
        }
        $purchase = Purchase::find($payment->purchase_id);
        $payment_status = purchase_payment_status("purchase", $purchase->id, $purchase->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $purchase->grand_total - $payment_status['amount'];
        $this->data['purchase'] = $purchase;
        $this->data['title'] = 'PURCHASE PAYMENT RECEIPT';
        $this->data['reference'] =  $payment->reference;
        $this->data['payment'] = $payment;
        $this->data['in_words'] = number_to_words($payment->amount);
        $this->data['show_payment'] = 'yes';
        $this->data['purchase_reference']  = "<li>Purchases Reference: &nbsp;&nbsp;&nbsp;<strong>" . $purchase->reference . "</strong></li>";
        $this->data['date'] = $payment->date;
        $this->data['heading'] = "Proccessed By:";
        $this->data['name'] = $payment->user->name;
        $this->data['qr'] = generateQr($payment->id, 'pdf', 'previewpurchase');
        $pdf = PDF::loadView('purchases.invoice', $this->data);
        $pdf->setPaper('A4');
        // return $pdf->stream('tutsmake.pdf', array('Attachment' => false));
        return $pdf->download('purchase_' . $payment->reference . '.pdf');
    }

    public function previewpurchase()
    {
        $code = request('payment');
        $payment_id = substr($code, 0, -3);
        $id = decrypt_code($payment_id);
        $payment = Payment::where('id', $id)->first();
        if (empty($payment)) {
            abort(403);
        }
        $purchase = Purchase::find($payment->purchase_id);
        $payment_status = purchase_payment_status("purchase", $purchase->id, $purchase->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $purchase->grand_total - $payment_status['amount'];
        $this->data['purchase'] = $purchase;
        $this->data['title'] = 'PURCHASE PAYMENT RECEIPT';
        $this->data['reference'] =  $payment->reference;
        $this->data['payment'] = $payment;
        $this->data['in_words'] = number_to_words($payment->amount);
        $this->data['show_payment'] = 'yes';
        $this->data['purchase_reference']  = "<li>Purchases Reference: &nbsp;&nbsp;&nbsp;<strong>" . $purchase->reference . "</strong></li>";
        $this->data['date'] = $payment->date;
        $this->data['heading'] = "Proccessed By:";
        $this->data['name'] = $payment->user->name;
        $this->data['qr'] = generateQr($payment->id, '', 'previewpurchase');
        return view('purchases.preview', $this->data);
    }
}
