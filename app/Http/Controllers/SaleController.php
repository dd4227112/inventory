<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'grand_total' => str_replace(',', '', $request->grand_total),
            'date' => $request->date,
            'user_id' => Auth::user()->id,
            'shop_id' => session('shop_id'),
            'customer_id' => $request->customer_id,
            'status' => 1,
        ];

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
            SaleProduct::create($product);
        }
        return redirect()->route('list_sale')->with('success', "Sale Added Successfully");
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
    public function viewsale($uuid){
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
    public function destroy(Request $request){

        if ( Sale::find($request->id)->delete() && SaleProduct::where('sale_id', $request->id)->delete() &&  Payment::where('sale_id', $request->id)->delete() ) {
           $response = ['message' =>'Deleleted Successfully'];
        }else{
            $response = ['message' =>'Failed to delete this sale'];
        }
        echo json_encode($response);
       
    }
    public function edit($uuid){
        $sale = Sale::where('uuid', $uuid)->first();
        if (empty($sale)) {
          abort(403);
        }
        $sale_items = SaleProduct::where('sale_id', $sale->id)->get();
        $this->data['sale'] = $sale;
        $this->data['items'] = $sale_items;
        return view('sales.edit', $this->data);
    }
    public function updatesale(Request $request){
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
        Sale::find($sale_id)->update($data);
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
        return redirect()->route('list_sale')->with('success', "Sale Updated Successfully");
    }
    
}
