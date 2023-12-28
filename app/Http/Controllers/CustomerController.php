<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shop;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $data;

    public function index()
    {
        $this->data['customers'] = Customer::where(['status'=> 1, 'shop_id'=>session('shop_id')])->get();
        return view('customer.index', $this->data);
    }

    public function addcustomer()
    {
        $this->data['shops'] = Shop::latest()->get();
        return view('customer.add',$this->data);
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');

        if (Customer::create($data)) {
            if ($request->add_ajax) {
                $message = ['message' => "Customer Added Successfully"];
                echo json_encode($message);
                exit;
            }
            return redirect()->route('list_customer')->with('success', "Customer Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to add new Customer.");
        }
    }
    public function getcustomer()
    {
        customers();
    }
    public function fetchcustomer($uuid)
    {
        $customer = Customer::where('uuid', $uuid)->first();
        if (empty($customer)) {
            abort(404);
        }
        $this->data['shops'] = Shop::latest()->get();
        $this->data['customer'] = $customer;
        return view('customer.edit', $this->data);
    }
    public function updatecustomer(Request $request)
    {
        $id = $request->customer_id;
        $data = $request->except(['customer_id', '_token']);
        $customer = Customer::find($id);
        if (!empty($customer) && $customer->update($data)) {
            return redirect()->route('list_customer')->with('success', "Customer Updated Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to update Customer.");
        }
    }

    public function deletecustomer(Request $request){
        $customer = Customer::find($request->id);
        if (empty($customer)) {
            $response = ['message' => 'Error!! Customer not found'];
            exit;
        }

        if ($customer->delete()) {
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }
}
