<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SupplierController extends Controller
{
    protected $data;

    public function index()
    {
        $this->data['suppliers'] = Supplier::where('status', 1)->get();
        return view('supplier.index', $this->data);
    }
    
    public function addsupplier()
    {
       
        return view('supplier.add');
    }
    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        if (Supplier::create($data)) {
            return redirect()->route('list_supplier')->with('success', "Supplier Added Successfully");
        }else{
            return redirect()->back()->with('error', "Failed to add new Supplier.");
        }
    }
    
    public function getsupplier()
    {
        supplier();
    }
}
