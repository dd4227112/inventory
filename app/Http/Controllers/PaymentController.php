<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
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
            return redirect()->back()->with('warning', "Can't accept greater amount than the current balance of ".$request->balance);
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
            return redirect()->route('list_purchase')->with('success', "Payment Added Successfully");
        }
        else{
            return redirect()->back()->with('error', "Failed to Add Payment");
        }
    }
}
