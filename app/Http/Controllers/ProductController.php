<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $data;
    
    public function index()
    {
        $products = Product::where('shop_id', session('shop_id'))->get();
        $this->data['products'] = $products;
        return view('products.index', $this->data);
    }

    public function  addproduct()
    {
        $this->data['shops'] = Shop::all();
        $this->data['categories'] = Category::all();
        $this->data['units'] = Unit::all();
        return view('products.add_product', $this->data);
    }
    public function store_product(Request $request)
    {
        $data = $request->except('_token');
        $user = ['user_id' =>Auth::user()->id];
        $data = $data + $user;
        if (Product::create($data)) {
            return redirect()->route('list_product')->with('success', "product Added Successfully");
        }else{
            return redirect()->back()->with('error', "Failed to add new product.");
        }
    }
    public function getProduct(){
       $search = request()->segment(2);
     products($search);
    }
    public function fetch_product(Request $request){
            fetch_sale($request);
    }
}
