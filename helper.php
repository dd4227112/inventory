<?php

use App\Models\Customer;
use App\Models\Product;


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
            $output .= "<tr class='add-icon pick_product' id ='" . $product->id . "'><td>" . $product->name ."(".$product->code.") - ".$product->description. "</td></tr>";
        }
        $output .= "</tbody>";
        $output .= "</table>";
    } else {
        echo "No product found";
    }
    echo $output;
}

function fetch($request)
{
    $id = $request->product_id;
    $product = Product::find($id);
    $output = '';
    if (!empty($product)) {
        $output .= "<tr><td class=''>" . $product->name ."(".$product->code.") - ".$product->description."</td>";
        $output .= "<td><input type ='number' name ='quantity[]' value ='1'</td>";
        $output .= "<td>".$product->price."</td>";
        $output .= "<td>".number_format(($product->price*1), 2)."</td>";
        $output .= "<td><a href='javascript:void(0);' class='delete-set'><img src='assets/img/icons/delete.svg' alt='svg'></a></td></tr>";
    } else {
        $output .= "Error!!";
    }
    echo $output;
}
function reference(){
    $reference = 'NTYD-'.time();
    return $reference;
}
