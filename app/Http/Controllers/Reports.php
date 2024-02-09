<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class Reports extends Controller
{
    protected $data;

    public function salesreport()
    {
        $products = Product::where('shop_id', session('shop_id'))->latest()->get();
        $summary = [];
        $balance =[];
        if (!$products->isEmpty()) {
            foreach ($products as $key => $product) {
                $summary[$product->id] = $this->sold($product->id);
                $balance[$product->id] = product_balance($product->id);
            }
        }
        $this->data['summary'] = $summary;
        $this->data['balance'] = $balance;
        $this->data['products'] = $products;
        $this->data['active'] = 'sale_report';
        return view('reports.sales', $this->data);
    }
    public function sold($product)
    {
        $summary = DB::select("SELECT coalesce(sum(quantity),0) as quantity, coalesce(sum(total), 0) as total from  sale_products where product_id =" . $product . " and deleted_at is null");
        if (!empty($summary)) {
            $result = [
                'sold' => $summary[0]->quantity,
                'amount' => $summary[0]->total
            ];
        } 
        else {
            $result = [
                'sold' => 0,
                'amount' => 0
            ];
        }
        return $result;
    }

    public function purchasereport()
    {
        $products = Product::where('shop_id', session('shop_id'))->latest()->get();
        $summary = [];
        $balance =[];
        if (!$products->isEmpty()) {
            foreach ($products as $key => $product) {
                $summary[$product->id] = $this->purchase($product->id);
                $balance[$product->id] = product_balance($product->id);
            }
        }
        $this->data['summary'] = $summary;
        $this->data['balance'] = $balance;
        $this->data['products'] = $products;
        $this->data['active'] = 'purchase_report';

        return view('reports.purchases', $this->data);
    }

    public function purchase($product)
    {
        $summary = DB::select("SELECT coalesce(sum(quantity),0) as quantity, coalesce(sum(total), 0) as total from  purchase_products where product_id =" . $product . " and deleted_at is  null");
        if (!empty($summary)) {
            $result = [
                'purchased' => $summary[0]->quantity,
                'amount' => $summary[0]->total
            ];
        } 
        else {
            $result = [
                'purchased' => 0,
                'amount' => 0
            ];
        }
        return $result;
    }

    public function inventoryreport()
    {
        return view('admin.incomming');
    }

    public function productreport()
    {
        $products = Product::where('shop_id', session('shop_id'))->latest()->get();
        $summary = [];
        if (!$products->isEmpty()) {
            foreach ($products as $key => $product) {
                $summary[$product->id] = product_balance($product->id);
            }
        }
        $this->data['summary'] = $summary;
        $this->data['products'] = $products;
        $this->data['active'] = 'product_report';
        return view('reports.products', $this->data);
    }
    public function productSale($id)
    {
        $product = Product::where('uuid', $id)->first();
        if (empty($product)) {
            abort(403);
        }
        $reports = SaleProduct::where('product_id', $product->id)->latest()->get();
        $sale = [];
        if (!$reports->isEmpty()) {

            foreach ($reports as $key => $report) {
                $sale[$report->id] = Sale::find($report->sale_id);
            }
        }
        $this->data['product']  = $product;
        $this->data['reports']  = $reports;
        $this->data['sale']  = $sale;
        $this->data['active'] = 'sale_report';
        return view('reports.productsale', $this->data);
    }


    public function productPurchase($id)
    {
        $product = Product::where('uuid', $id)->first();
        if (empty($product)) {
            abort(403);
        }
        $reports = PurchaseProduct::where('product_id', $product->id)->latest()->get();
        $purchase = [];
        if (!$reports->isEmpty()) {

            foreach ($reports as $key => $report) {
                $purchase[$report->id] = Purchase::find($report->purchase_id);
            }
        }
        $this->data['product']  = $product;
        $this->data['reports']  = $reports;
        $this->data['purchase']  = $purchase;
        $this->data['active'] = 'purchase_report';
        return view('reports.productpurchase', $this->data);
    }
    public function combinedProduct($id)
    {
        //product
        $product = Product::where('uuid', $id)->first();
        if (empty($product)) {
            abort(403);
        }
        $this->data['product']  = $product;
        //purchases
        $purchasereports = PurchaseProduct::where('product_id', $product->id)->latest()->get();
        $purchase = [];
        if (!$purchasereports->isEmpty()) {

            foreach ($purchasereports as $key => $report) {
                $purchase[$report->id] = Purchase::find($report->purchase_id);
            }
        }

        $this->data['purchasereports']  = $purchasereports;
        $this->data['purchase']  = $purchase;
        // sales 
        $salesreports = SaleProduct::where('product_id', $product->id)->latest()->get();
        $sale = [];
        if (!$salesreports->isEmpty()) {

            foreach ($salesreports as $key => $report) {
                $sale[$report->id] = Sale::find($report->sale_id);
            }
        }
        $this->data['salesreports']  = $salesreports;
        $this->data['sale']  = $sale;
        $this->data['active'] = 'product_report';
        return view('reports.combinedproduct', $this->data);
    }
}
