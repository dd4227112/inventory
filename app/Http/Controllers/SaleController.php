<?php

namespace App\Http\Controllers;

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
}
