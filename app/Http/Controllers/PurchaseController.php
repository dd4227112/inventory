<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    protected $data;
    public function index()
    {
        $purchases = Purchase::where('shop_id', session('shop_id'))->get();
        $payment = [];
        if (!$purchases->isEmpty()) {
            foreach ($purchases as $key => $purchase) {
                $payment[$purchase->id] =  $purchase->payment->sum('amount');
            }
        }
        $this->data['payments'] = $payment;
        $this->data['purchases'] = $purchases;
        return view('purchases.index', $this->data);
    }

    public function  addpurchase()
    {
        $this->data['shops'] = Shop::all();
        return view('purchases.add', $this->data);
    }
    public function store(Request $request)
    {

        $data = [
            'reference' => $request->reference,
            'grand_total' => str_replace(',', '', $request->grand_total),
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'shop_id' => session('shop_id'),
            'supplier_id' => $request->supplier_id,
            'status' => 1,
        ];

        $purchase = Purchase::create($data);

        $size  = sizeof($request->product_id);
        for ($i = 0; $i < $size; $i++) {
            $product = [
                'date' => $request->date,
                'quantity' => $request->quantity[$i],
                'product_id' => $request->product_id[$i],
                'price' => $request->price[$i],
                'total' => ($request->quantity[$i] * $request->price[$i]),
                'purchase_id' => $purchase->id,
            ];
            PurchaseProduct::create($product);
        }
        // add payement if posted
        if ($request->payment_amount != ' ' && $request->payment_amount  > 0) {
            if (remove_comma($request->payment_amount) > remove_comma($request->grand_total)) {
                return redirect()->route('view_purchase', $purchase->uuid)->with('warning', "Sale Added but Payment not added because greater amount posted");
            }
            $data = [
                'amount' => remove_comma($request->payment_amount),
                'reference' => $request->payment_reference,
                'date' => $request->date,
                'purchase_id' => $purchase->id,
                'user_id' => Auth::user()->id,
                'status' => 1,
                'payment_method' => $request->payment_method,
                'description' => $request->description,

            ];
            Payment::create($data);
        }
        return redirect()->route('view_purchase', $purchase->uuid)->with('success', "purchase Added Successfully");
    }

    //get selected product on adding purchase via ajax request
    public function fetch_purchase(Request $request)
    {
        fetch_purchase($request);
    }
    public function deletepurchase(Request $request)
    {
        $purchase =Purchase::find($request->id);
        if ($purchase->delete()) {
            $purchase->update(['deleted_by'=>Auth::user()->id]);
            purchaseProduct::where('purchase_id', $request->id)->delete();
            Payment::where('purchase_id', $request->id)->update(['deleted_by'=>Auth::user()->id]);
            Payment::where('purchase_id', $request->id)->delete();

            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this purchase'];
        }
        echo json_encode($response);
    }
    public function singlePurchasePayment(Request $request)
    {
        $id  = $request->id;
        $purchase = Purchase::find($id);
        $payments = Payment::where('purchase_id', $request->id)->get();
        $html = " ";
        if (!$payments->isEmpty()) {
            foreach ($payments as $key => $payment) {
                $html .=  "<tr class='bor-b1'>";
                $html  .= "<td>" . $payment->date . "</td>";
                $html  .= "<td>" . $purchase->supplier->name . "</td>";
                $html  .= "<td>" . $payment->reference . "</td>";
                $html  .= "<td>" . number_format($payment->amount, 2) . " </td>";
                $html  .= "<td>Cash</td>";
                $html  .= "<td>" . $payment->description . " </td>";
                $html  .= "<td>" . $payment->user->name . " </td>";
                $html  .= "<td>
                    <a class='me-2' href='" . route('purchase_payment_receipt', $payment->uuid) . "'>
                        <img src='" . url('assets/img/icons/printer.svg') . "' alt='img'>
                    </a>
                    <a class='me-2 getPayment' id = '" . $payment->id . "' href='javascript:void(0);' 
                        data-bs-dismiss='modal'>
                        <img src= '" . url('assets/img/icons/edit.svg') . "' alt='img'>
                    </a>
                    <a class='me-2 deletePayment' id = '" . $payment->id . "' href='javascript:void(0);'>
                        <img src='" . url('assets/img/icons/delete.svg') . "' alt='img'>
                    </a>
                </td>
            </tr>";
            }
        }
        echo $html;
    }

    public function purchase_payment_receipt()
    {
    }
    public function viewpurchase($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();
        if (empty($purchase)) {
            abort(403);
        }
        $payment_status = purchase_payment_status("purchase", $purchase->id, $purchase->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $purchase->grand_total - $payment_status['amount'];
        $this->data['purchase'] = $purchase;
        return view('purchases.details', $this->data);
    }
    public function editpurchase($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();
        if (empty($purchase)) {
            abort(403);
        }
        $purchase_items = PurchaseProduct::where('purchase_id', $purchase->id)->get();
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
        // we removed edit payment record during edit purchase because payment has its own edit method
        $this->data['purchase'] = $purchase;
        $this->data['items'] = $purchase_items;
        return view('purchases.edit', $this->data);
    }

    public function printpurchase($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();
        if (empty($purchase)) {
            abort(403);
        }
        $payment_status = purchase_payment_status("purchase", $purchase->id, $purchase->grand_total);
        $this->data['status'] = $payment_status['status'];
        $this->data['class'] = $payment_status['class'];
        $this->data['paid'] = $payment_status['amount'];
        $this->data['balance'] = $purchase->grand_total - $payment_status['amount'];
        $this->data['purchase'] = $purchase;
        $this->data['title'] = 'PURCHASE INVOICE';
        $this->data['reference'] =  $purchase->reference;
        $this->data['purchase_reference']  = '';
        $this->data['date'] = $purchase->date;
        $this->data['heading'] = "Created By:";

        $this->data['name'] = $purchase->user->name;

        // check the number of payment per purchase
        $count = Payment::where('purchase_id', $purchase->id)->count();
        if ($count > 1) {
            $this->data['show_payment'] = 'no';
            $this->data['payment'] = '';
            $this->data['in_words'] = '';
        } else {
            $payment = Payment::where('purchase_id', $purchase->id)->first();
            $this->data['show_payment'] = 'no';
            if (!empty($payment)) {
                $this->data['show_payment'] = 'yes';
                $this->data['payment'] = $payment;
                $this->data['in_words'] = number_to_words($payment->amount);
                $this->data['qr'] = generateQr($payment->id, 'pdf', 'previewpurchase');
            }
        }
        $pdf = PDF::loadView('purchases.invoice', $this->data);
        $pdf->setPaper('A4');
        // return $pdf->stream('tutsmake.pdf', array('Attachment' => false));
        return $pdf->download('purchases_' . $purchase->reference . '.pdf');
    
    }
    public function updatepurchase(Request $request)
    {
        $purchase_id = $request->purchase_id;
        $data = [
            'reference' => $request->reference,
            'grand_total' => str_replace(',', '', $request->grand_total),
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'shop_id' => session('shop_id'),
            'supplier_id' => $request->supplier_id,
            'status' => 1,
        ];
        $purchase = Purchase::find($purchase_id);
        $purchase->update($data);
        PurchaseProduct::where('purchase_id', $purchase_id)->delete();
        $size  = sizeof($request->product_id);
        for ($i = 0; $i < $size; $i++) {
            $product = [
                'date' => $request->date,
                'quantity' => $request->quantity[$i],
                'product_id' => $request->product_id[$i],
                'price' => $request->price[$i],
                'total' => ($request->quantity[$i] * $request->price[$i]),
                'purchase_id' => $purchase_id,
            ];
            PurchaseProduct::create($product);
        }
        return redirect()->route('view_purchase', $purchase->uuid)->with('success', "Purchase Updated Successfully");
    }
}
