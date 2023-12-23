<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Supplier;

function upload_file($file, $subpath)
{
    $filename = $file->getClientOriginalName();
    $path = public_path('uploads/' . $subpath . '/');

    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true);
    }
    $file->move($path, $filename);

    return $filename;
}

function delete_file($filename, $subpath)
{
    $path = public_path('uploads/' . $subpath . '/');
    if (File::exists($path . $filename) && !File::isDirectory($path . $filename)) {
        File::delete($path . $filename);
    }
}
function customers()
{
    $customers = Customer::where('status', 1)->get();
    $output = " ";
    if (!$customers->isEmpty()) {
        foreach ($customers as $key => $customer) {
            $output .= " <option value='" . $customer->id . "'>" . $customer->name . "</option>";
        }
    } else {
        $output = " <option value=''>No Customer Registered</option>";
    }

    echo $output;
}
function supplier()
{
    $suppliers = Supplier::where('status', 1)->get();
    $output = " ";
    if (!$suppliers->isEmpty()) {
        foreach ($suppliers as $key => $supplier) {
            $output .= " <option value='" . $supplier->id . "'>" . $supplier->name . "</option>";
        }
    } else {
        $output = " <option value=''>No Supplier Registered</option>";
    }

    echo $output;
}
function products($key)
{
    $products = Product::where('shop_id', session('shop_id'))
        ->where(function ($query) use ($key) {
            $query->where('name', 'like', "%$key%")
                ->orWhere('code', 'like', "%$key%");
        })
        ->latest()
        ->take(10)
        ->get();

    $output = '';
    if (!$products->isEmpty()) {
        $output .= "<table class='table table-bordered mb-0'>";
        $output .= "<tbody>";
        foreach ($products as $key => $product) {
            $output .= "<tr class='add-icon pick_product' id ='" . $product->id . "'><td>" . $product->name . "(" . $product->code . ") - " . $product->description . "</td></tr>";
        }
        $output .= "</tbody>";
        $output .= "</table>";
    } else {
        echo "No product found";
    }
    echo $output;
}

function fetch_sale($request)
{
    $id = $request->product_id;
    $product = Product::find($id);
    $output = '';
    if (!empty($product)) {
        $output .= "<tr><td class=''>" . $product->name . "(" . $product->code . ") - " . $product->description . "</td>";
        $output .= " <input class ='' type ='hidden' id ='product_id' name ='product_id[]' value ='" . $product->id . "'>";
        $output .= "<td><input type ='number' id='quantity' max='" . $product->quantity . "' name ='quantity[]' value ='1'></td>";
        $output .= "<td><input type ='text' id='price' readonly name ='price[]' value ='" . $product->price . "'></td>";
        $output .= "<td><input type ='text' id='sub_total' readonly name ='sub_total[]' value ='" . ($product->price * 1) . "'></td>";
        $output .= "<td><a href='javascript:void(0);' id='remove'><img src='{{ asset('assets/img/icons/delete.svg')}}' alt='svg' title='remove this items'></a></td></tr>";
    } else {
        $output .= "Error!!";
    }
    echo $output;
}

function fetch_purchase($request)
{
    $id = $request->product_id;
    $product = Product::find($id);
    $output = '';
    if (!empty($product)) {
        $output .= "<tr><td class=''>" . $product->name . "(" . $product->code . ") - " . $product->description . "</td>";
        $output .= " <input class ='' type ='hidden' id ='product_id' name ='product_id[]' value ='" . $product->id . "'>";
        $output .= "<td><input type ='number' id='quantity' max='" . $product->quantity . "' name ='quantity[]' value ='1'></td>";
        $output .= "<td><input type ='text' id='price' readonly name ='price[]' value ='" . $product->cost . "'></td>";
        $output .= "<td><input type ='text' id='sub_total' readonly name ='sub_total[]' value ='" . ($product->price * 1) . "'></td>";
        $output .= "<td><a href='javascript:void(0);' id='remove'><img src='{{ asset('assets/img/icons/delete.svg')}}' alt='svg' title='remove this items'></a></td></tr>";
    } else {
        $output .= "Error!!";
    }
    echo $output;
}
function reference()
{
    $reference = 'NTYD-' . time();
    return $reference;
}
function product_balance($product)
{
    $purchased = PurchaseProduct::where('product_id', $product)->sum('quantity');
    $sold = SaleProduct::where('product_id', $product)->sum('quantity');
    return ['purchased' => $purchased, 'sold' => $sold, 'balance' => ($purchased - $sold)];
}
function remove_comma($number)
{
    return str_replace(',', '', $number);
}

function sale_payment_status($table, $id, $grand_total)
{
   $result = Sale::where('id', $id)->first();
  //  dd($table, $id, $grand_total, $result);
    $amount = $result->payment->sum('amount');
    if ($grand_total == $amount) {
        $status = "Completed";
        $class = "text-success";
    } elseif (($amount < $grand_total) && ($amount > 0)) {
        $status = "Partial";
        $class = "text-warning";
    } else {
        $status = "Pending";
        $class = "text-danger";
    }
    return ['status'=>$status, 'class' =>$class, 'amount'=>$amount];
}
