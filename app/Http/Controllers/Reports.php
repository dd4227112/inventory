<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class Reports extends Controller
{
    protected $data;

    public function salesreport()
    {
        return view('reports.sales');
    }

    public function purchasereport()
    {
        return view('reports.purchases');
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

        return view('reports.combinedproduct', $this->data);
    }
}
