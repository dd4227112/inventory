<?php

namespace App\Http\Controllers;

use App\Models\Sale;
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
    public function store_sale(Request $request)
    {
        $data = $request->except('_token');
        $user = ['user_id' =>Auth::user()->id];
        $data = $data + $user;
        if (sale::create($data)) {
            return redirect()->route('list_sale')->with('success', "Sale Added Successfully");
        }else{
            return redirect()->back()->with('error', "Failed to add new sale.");
        }
    }
}

