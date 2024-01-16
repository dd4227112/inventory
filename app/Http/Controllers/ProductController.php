<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\Models\SaleProduct;
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
        $user = ['user_id' => Auth::user()->id];
        $data = $data + $user;
        if (Product::create($data)) {
            return redirect()->route('list_product')->with('success', "product Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to add new product.");
        }
    }
    public function getSaleProduct()
    {
        $search = request()->segment(2);
        searchSaleProduct($search);
    }
    public function getPurchaseProduct()
    {
        $search = request()->segment(2);
        searchPurchaseProduct($search);
    }
    public function fetch_product(Request $request)
    {
        fetch_sale($request);
    }
    public function edit($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        if (empty($product)) {
            abort(403);
        }
        $this->data['shops'] = Shop::all();
        $this->data['categories'] = Category::all();
        $this->data['units'] = Unit::all();
        $this->data['product'] = $product;
        return view('products.edit', $this->data);
    }
    public function updateProduct(Request $request)
    {
        $product = Product::find($request->product_id);
        if (empty($product)) {
            abort(403);
        }
        $data = $request->except(['product_id', '_token']);
        if ($product->update($data)) {
            return redirect()->route('list_product')->with('success', "Product Updated Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to update product.");
        }
    }

    public function  deleteproduct(Request $request)
    {
        $product = Product::find($request->id);
        if ($product->delete()) {
            $product->update(['deleted_by'=>Auth::user()->id]);
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this product'];
        }
        echo json_encode($response);
    }
}
