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

    public function fetchsupplier($uuid)
    {
        $supplier = Supplier::where('uuid', $uuid)->first();
        if (empty($supplier)) {
            abort(404);
        }
        $this->data['supplier'] = $supplier;
        return view('supplier.edit', $this->data);
    }
    public function updatesupplier(Request $request)
    {
        $id = $request->supplier_id;
        $data = $request->except(['supplier_id', '_token']);
        $supplier = Supplier::find($id);
        if (!empty($supplier) && $supplier->update($data)) {
            return redirect()->route('list_supplier')->with('success', "supplier Updated Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to update supplier.");
        }
    }


    
     public function deletesupplier(Request $request){
        $supplier = Supplier::find($request->id);
        if (empty($supplier)) {
            $response = ['message' => 'Error!! supplier not found'];
            exit;
        }

        if ($supplier->delete()) {
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }
}
