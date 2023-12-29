<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Shop;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Admin extends Controller
{

    protected $data;

    public function __construct()
    {
    }
    public function index()
    {
        $this->data['shops'] = Shop::latest()->get();
        return view('admin.index', $this->data);
    }
    public function home(Request $request)
    {
        $shop =  Shop::find($request->id);
        if ($shop) {
            Session::put('shop_id', $shop->id);

            Session::put('shop_name', $shop->name);
            return redirect()->route('admin.dashboard')->with('success', "Welcome to " . session('shop_name') . " Shop!");
        } else {
            return redirect()->back()->with('error', 'Shop not found.');
        }
    }
    public function dashboard()
    {
        $shop_id = session('shop_id');
        $date = date('Y-m-d');
        $this->data['total_purchases'] = Purchase::where('shop_id', $shop_id)->sum('grand_total');
        $this->data['total_sales'] = Sale::where('shop_id', $shop_id)->sum('grand_total');
        $this->data['number_purchases'] = Purchase::where(['shop_id'=>$shop_id, 'date'=>$date])->count();
        $this->data['number_sales'] = Sale::where(['shop_id'=>$shop_id, 'date'=>$date])->count();
        $this->data['today_purchases'] = Purchase::where(['shop_id'=>$shop_id, 'date'=>$date])->sum('grand_total');
        $this->data['today_sales'] = Sale::where(['shop_id'=>$shop_id, 'date'=>$date])->sum('grand_total');
        $this->data['customers'] = Customer::where('shop_id', $shop_id)->count();
        $this->data['suppliers'] = Supplier::where('shop_id', $shop_id)->count();
        $this->data['all_product'] = Product::where('shop_id', $shop_id)->count();
        $this->data['in_stock'] = Product::where('shop_id', $shop_id)->whereIn('id', inStockProducts())->count();
        $this->data['out_stock'] = Product::where('shop_id', $shop_id)->whereIn('id', outStockProducts())->count();
        $this->data['most_solds'] =  Product::where('shop_id', $shop_id)->whereIn('id', most_sold())->get();
       
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $sales =[];
        $purchases =[];
        $year = date('Y');
        foreach($months as $i=>$value){
            $sale = DB::select("select coalesce(sum(grand_total),0) as sales from sales where extract(YEAR from date) = ".$year." and extract(MONTH from date) =".$value." and shop_id =".$shop_id." and deleted_at is null");
            $purchase = DB::select("select coalesce(sum(grand_total),0) as purchases from purchases where extract(YEAR from date) = ".$year." and extract(MONTH from date) =".$value." and shop_id =".$shop_id." and deleted_at is null");
          
            $sales[] = (int)$sale[0]->sales;
          
            $purchases[] = (int)$purchase[0]->purchases;
           
        }
        $this->data['sales_chart'] = implode(',' , $sales);
               
        $this->data['purchases_chart'] = implode(',' , $purchases);
        //recent five sales with their payments
        $this->data['sales'] = $sales = Sale::where('shop_id', session('shop_id'))->latest()->take(5)->get();
        $payment = [];
        if (!$sales->isEmpty()) {
            foreach ($sales as $key => $sale) {
                $payment[$sale->id] =  $sale->payment->sum('amount');
            }
        }
        $this->data['payments'] = $payment;
         //recent five sales with their payments
        $purchases = Purchase::where('shop_id', session('shop_id'))->latest()->take(5)->get();
        $purchase_payment = [];
        if (!$purchases->isEmpty()) {
            foreach ($purchases as $key => $purchase) {
                $purchase_payment[$purchase->id] =  $purchase->payment->sum('amount');
            }
        }
        $this->data['purchase_payment'] = $purchase_payment;
        $this->data['purchases'] = $purchases;

       return view('admin.dashboard', $this->data);
    //    return view('admin.incomming');
    }

    // USERS
    public function user()
    {
        $users = User::where('status', 1)->latest()->get();
        $this->data['users'] = $users;
        return view('admin.user', $this->data);
    }

    public function addUser()
    {
        $this->data['shops'] = Shop::latest()->get();
        $this->data['roles'] = Role::all();
        return view('admin.add_user', $this->data);
    }
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ];
        if (Role::find($request->role_id)->name != 'Sales') {
            $data['shop_id'] = null;
        } else {
            $data['shop_id'] = $request->shop_id;
        }
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $maxFileSize = 5242880; // 5MB
            $extension = $file->extension();
            $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico', 'webp', 'jfif'];

            if ($file->getSize() > $maxFileSize) {
                return redirect()->back()->with('warning', 'File size exceeds the maximum limit of 5MB.');
            }
            if (in_array($extension, $allowedImageExtensions)) {
                $filename = upload_file($file, 'profiles');
                // $file_type = 'Image';
                $data['photo'] = $filename;
            } else {
                return redirect()->back()->with('warning', 'Invalid file type. Only  images (jpg,jpeg,png,webp)  files are allowed.');
            }
        }
        if (User::create($data)) {
            return redirect()->route('admin.list_user')->with('success', "User Added Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Register new User");
        }
    }

    public function viewUser()
    {
    }
    public function getUser($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (empty($user)) {
            abort(404);
        }
        $this->data['user'] = $user;
        $this->data['shops'] = Shop::latest()->get();
        $this->data['roles'] = Role::all();
        return view('admin.edit_user', $this->data);
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request->user_id);
        if (empty($user)) {
            abort(404);
        }
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
            'role_id' => $request->role_id
        ];
        if (Role::find($request->role_id)->name != 'Sales') {
            $data['shop_id'] = null;
        } else {
            $data['shop_id'] = $request->shop_id;
        }
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $maxFileSize = 5242880; // 5MB
            $extension = $file->extension();
            $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico', 'webp', 'jfif'];

            if ($file->getSize() > $maxFileSize) {
                return redirect()->back()->with('warning', 'File size exceeds the maximum limit of 5MB.');
            }
            if (in_array($extension, $allowedImageExtensions)) {
                $filename = upload_file($file, 'profiles');
                // $file_type = 'Image';
                $data['photo'] = $filename;
            } else {
                return redirect()->back()->with('warning', 'Invalid file type. Only  images (jpg,jpeg,png,webp)  files are allowed.');
            }
        }
        delete_file($user->photo, 'profiles');
        if ($user->update($data)) {
            return redirect()->route('admin.list_user')->with('success', "User Updated Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Update  User");
        }
    }
    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if (empty($user)) {
            $response = ['message' => 'Error!! User not found'];
            exit;
        }
        delete_file($user->photo, 'profiles');
        if ($user->delete()) {
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this sale'];
        }
        echo json_encode($response);
    }
    public function resetUser(Request $request)
    {
        $user = User::find($request->id);
        if (empty($user)) {
            $response = ['message' => 'Error!! User not found'];
            exit;
        }
        $password = Hash::make($user->email);

        if ($user->update(['password' => $password])) {
            $response = ['message' => 'Password Reset Successfully'];
        } else {
            $response = ['message' => 'Failed to reset for  this sale'];
        }
        echo json_encode($response);
    }

    //SHOPS
    public function shop()
    {
        $shops = Shop::all();
        $this->data['shops'] = $shops;
        return view('admin.shop', $this->data);
    }

    public function  addshop()
    {
        return view('admin.add_shop');
    }
    public function store_shop(Request $request)
    {
        $data = $request->except('_token');
        if (Shop::create($data)) {
            return redirect()->route('admin.list_shop')->with('success', "Shop Added Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to add new shop.");
        }
    }



    public function deleteshop(Request $request)
    {
        $shop = Shop::find($request->id);
        if (empty($shop)) {
            $response = ['message' => 'Error!! Shop not found'];
            exit;
        }
        if ($shop->delete()) {
            $response = ['message' => 'Deleleted Successfully'];
        } else {
            $response = ['message' => 'Failed to delete this shop'];
        }
        echo json_encode($response);
    }

    public function fetchshop($uuid)
    {
        $shop = Shop::where('uuid', $uuid)->first();
        if (empty($shop)) {
            abort(404);
        }
        $this->data['shop'] = $shop;
        return view('admin.edit_shop', $this->data);
    }
    public function updateshop(Request $request)
    {
        $id = $request->shop_id;
        $data = $request->except(['shop_id', '_token']);
        $shop = Shop::find($id);
        if (!empty($shop) && $shop->update($data)) {
            return redirect()->route('admin.list_shop')->with('success', "Shop Updated Successfully");
        } else {
            return redirect()->back()->with('error', "Failed to update Shop.");
        }
    }
    public function profile()
    {
        return view('admin.profile');
    }
    public function profilephoto(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $maxFileSize = 5242880; // 5MB
            $extension = $file->extension();
            $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico', 'webp', 'jfif'];

            if ($file->getSize() > $maxFileSize) {
                return redirect()->back()->with('warning', 'File size exceeds the maximum limit of 5MB.');
            }
            if (in_array($extension, $allowedImageExtensions)) {
                $filename = upload_file($file, 'profiles');
                // $file_type = 'Image';
                $data['photo'] = $filename;
            } else {
                return redirect()->back()->with('warning', 'Invalid file type. Only  images (jpg,jpeg,png,webp)  files are allowed.');
            }
        }
        delete_file($user->photo, 'profiles');
        if ($user->update($data)) {
            return redirect()->route('profile')->with('success', "Photo Updated Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Update  User Photo");
        }
    }
    public function updateprofile(Request $request){
        $user  =  $user = User::find(Auth::user()->id);
        $data = [
            'name' =>$request->name,
            'email' =>$request->email,
            'phone' =>$request->phone,
        ];
        if ($user->update($data)) {
            return redirect()->route('profile')->with('success', "Profile Updated Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Update  User Profile");
        }
    }
    public function password(){
        return view('admin.password');
    }
    public function changepassword(Request $request){ 
        $user   = User::find(Auth::user()->id);
        $current = $request->current_password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;

        if ($new != $confirm) {
            return  redirect()->back()->with('warning', "Passwords not match");
        }
        $currentPassword = Hash::make($current);
        $new = Hash::make($new);
        if ($currentPassword != $user->password) {
            return  redirect()->back()->with('warning', "Incorrect current/old Password");
        }
        if ($user->update(['password'=>$new])) {
            return redirect()->route('profile')->with('success', "Password Changed Successfully");
        }else {
            return  redirect()->back()->with('error', "Unable to Change Password");
        }
    } 
}
