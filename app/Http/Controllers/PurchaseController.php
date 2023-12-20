<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    protected $data;
    public function index()
    {
        $purchases = Purchase::where('shop_id', session('shop_id'))->get();
        $payment = [];
        foreach ($purchases as $key => $purchase) {
            $payment[$purchase->id] =  $purchase->payment->sum('amount');
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
        return redirect()->route('list_purchase')->with('success', "purchase Added Successfully");
    }

    //get selected product on adding purchase via ajax request
    public function fetch_purchase(Request $request)
    {
        fetch_purchase($request);
    }
}
