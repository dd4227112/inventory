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
                'purchase_amount' => number_format($purchase->grand_total, 2),
            ];
        } else {
            $data = [
                'supplier' => '',
                'purchase_id' => '',
                'purchase_amount' => '',
            ];
        }
        echo json_encode($data);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
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
