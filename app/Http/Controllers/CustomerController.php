<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $data;

    public function index()
    {
        $this->data['customers'] = Customer::where('status', 1)->get();
        return view('customer.index', $this->data);
    }

    public function addcustomer()
    {

        return view('customer.add');
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');

        if (Customer::create($data)) {
            return redirect()->route('list_customer')->with('success', "Customer Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to add new Customer.");
        }
    }
    public function getcustomer()
    {
        customers();
    }
}
