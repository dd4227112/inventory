<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Shop;
use App\Models\Supplier;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
function searchSaleProduct($key)
{
    $products = Product::where('shop_id', session('shop_id'))
        ->where(function ($query) use ($key) {
            $query->where('name', 'like', "%$key%")
                ->orWhere('code', 'like', "%$key%");
        })
        ->latest()
        ->take(10)
        ->get();
    // From the search result filter only which its remaining balance is greater than 0
    $products = Product::whereIn('id', overallProductBalance($products))->get();

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
        $output .= "<td><a href='javascript:void(0);' id='remove'><img src='assets/img/icons/delete.svg' alt='svg' title='remove this items'></a></td></tr>";
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
        $output .= "<tr><td class=''>" . $product->name . "(" . $product->code . ") - " . $product->description;
        $output .= " <input class ='' type ='hidden' id ='product_id' name ='product_id[]' value ='" . $product->id . "'></td>";
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
function overallProductBalance($products = [])
{
    $product_ids  = [];
    foreach ($products as $product) {
        $purchased = PurchaseProduct::where('product_id', $product->id)->sum('quantity');
        $sold = SaleProduct::where('product_id', $product->id)->sum('quantity');
        if ($purchased - $sold > 0) {
            $product_ids[] = $product->id;
        }
    }
    return $product_ids;
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
    return ['status' => $status, 'class' => $class, 'amount' => $amount];
}
function site_address($shop = null)
{
    if (isset($shop) && $shop != null) {
        $id = $shop;
    }
    else{
        $id = session('shop_id');
    }
   
    $shop = Shop::find($id);
    $address = "";
    $address .= "<p>";
    $address .= "<b>" . $shop->name . "</b><br>";
    $address .= $shop->address . "<br>";
    $address .= $shop->location . "<br>";
    $address .= $shop->phone . "<br>";
    $address .= " </p>";
    return $address;
}
function number_to_words($number)
{
    if (($number < 0) || ($number > 999999999)) {
        return "$number";
    }

    $Gn = floor($number / 1000000);  /* Millions (giga) */
    $number -= $Gn * 1000000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10; /* Ones */

    $res = "";

    if ($Gn) {
        $res .= number_to_words($Gn) . " Million";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
            number_to_words($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
            number_to_words($Hn) . " Hundred";
    }

    $ones = array(
        "", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen"
    );
    $tens = array(
        "", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety"
    );

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}
function encrypt_code($number)
{
    $replace = ['A', 'e_', 'jk', 'F{', 'rgc', 'Db', 'm$', 'Z-', 'd', 'xY'];
    $key = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

    $number = str_replace($key, $replace, $number);
    return $number;
}
function decrypt_code($number)
{
    $replace = ['A', 'e_', 'jk', 'F{', 'rgc', 'Db', 'm$', 'Z-', 'd', 'xY'];
    $key = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
    if (!in_array($number, $replace)) {
       abort(403);
    }

    $number = str_replace($replace, $key, $number);
    return $number;
}
function generateQr($id, $format, $controller)
{
    $append = random_int(100, 999);
    $payment_code = encrypt_code($id) . $append;
    $code = url($controller.'?payment=' . $payment_code);
    $qrCode = QrCode::generate(
        $code
    );
    if ($format == 'pdf') {
        $output = '<img src="' . 'data:image/png;base64,' . base64_encode($qrCode) . '">';
    } else {
        $output = $qrCode;
    }

    return $output;
}

function searchPurchaseProduct($key)
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


function purchase_payment_status($table, $id, $grand_total)
{
    $result = Purchase::where('id', $id)->first();
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
    return ['status' => $status, 'class' => $class, 'amount' => $amount];
}
