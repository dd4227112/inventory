<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
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
        return view('admin.home');
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
    public function getUser()
    {
    }

    public function updateUser()
    {
    }
    public function deleteUser()
    {
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
        }else{
            return redirect()->back()->with('error', "Failed to add new shop.");
        }
    }
}
