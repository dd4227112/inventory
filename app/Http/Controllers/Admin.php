<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Permissions;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Shop;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Category;




class Admin extends Controller
{

    protected $data;

    public function __construct()
    {
    }
    public function index()
    {
        $this->data['shops'] = Shop::latest()->get();
        $this->data['active'] = 'switch_shop';
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
        $this->data['number_purchases'] = Purchase::where(['shop_id' => $shop_id, 'date' => $date])->count();
        $this->data['number_sales'] = Sale::where(['shop_id' => $shop_id, 'date' => $date])->count();
        $this->data['today_purchases'] = Purchase::where(['shop_id' => $shop_id, 'date' => $date])->sum('grand_total');
        $this->data['today_sales'] = Sale::where(['shop_id' => $shop_id, 'date' => $date])->sum('grand_total');
        $this->data['customers'] = Customer::where('shop_id', $shop_id)->count();
        $this->data['suppliers'] = Supplier::where('shop_id', $shop_id)->count();
        $this->data['all_product'] = Product::where('shop_id', $shop_id)->count();
        $this->data['in_stock'] = Product::where('shop_id', $shop_id)->whereIn('id', inStockProducts())->count();
        $this->data['out_stock'] = Product::where('shop_id', $shop_id)->whereIn('id', outStockProducts())->count();
        $this->data['most_solds'] =  Product::where('shop_id', $shop_id)->whereIn('id', most_sold())->get();

        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $sales = [];
        $purchases = [];
        $year = date('Y');
        foreach ($months as $i => $value) {
            $sale = DB::select("select coalesce(sum(grand_total),0) as sales from sales where extract(YEAR from date) = " . $year . " and extract(MONTH from date) =" . $value . " and shop_id =" . $shop_id . " and deleted_at is null");
            $purchase = DB::select("select coalesce(sum(grand_total),0) as purchases from purchases where extract(YEAR from date) = " . $year . " and extract(MONTH from date) =" . $value . " and shop_id =" . $shop_id . " and deleted_at is null");

            $sales[] = (int)$sale[0]->sales;

            $purchases[] = (int)$purchase[0]->purchases;
        }
        $this->data['sales_chart'] = implode(',', $sales);

        $this->data['purchases_chart'] = implode(',', $purchases);
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
        $this->data['active'] = 'dashbaord';


        return view('admin.dashboard', $this->data);
        //    return view('admin.incomming');
    }

    // USERS
    public function user()
    {
        $users = User::where('status', 1)->latest()->get();
        $this->data['users'] = $users;
        $this->data['active'] = 'list_user';
        return view('admin.user', $this->data);
    }

    public function addUser()
    {
        $this->data['shops'] = Shop::latest()->get();
        $this->data['roles'] = Role::all();
        $this->data['active'] = 'add_user';
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
        $this->data['active'] = 'list_user';
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
            $user->update(['deleted_by' => Auth::user()->id]);
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
        $this->data['active'] = 'list_shop';
        return view('admin.shop', $this->data);
    }

    public function  addshop()
    {
        $this->data['active'] = 'add_shop';
        return view('admin.add_shop', $this->data);
    }
    public function store_shop(Request $request)
    {
        // $request->validate([
        //     'name' => 'string|required|min:5|max:50|unique:name'
        // ]);

        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50', 'unique:shops'],

        ]);
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
            $shop->update(['deleted_by' => Auth::user()->id]);
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
        $this->data['active'] = 'list_shop';
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
        $this->data['active'] = 'profile';
        return view('admin.profile', $this->data);
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
    public function updateprofile(Request $request)
    {
        $user  =  $user = User::find(Auth::user()->id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
        if ($user->update($data)) {
            return redirect()->route('profile')->with('success', "Profile Updated Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Update  User Profile");
        }
    }
    public function password()
    {
        $this->data['active'] = 'password';
        return view('admin.password', $this->data);
    }
    public function changepassword(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $current = $request->current_password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;

        if ($new != $confirm) {
            return  redirect()->back()->with('warning', "Passwords not match");
        }
        $new = Hash::make($new);
        if (!Hash::check($current, $user->password)) {
            return  redirect()->back()->with('warning', "Incorrect current/old Password");
        }
        if ($user->update(['password' => $new])) {
            return redirect()->route('profile')->with('success', "Password Changed Successfully");
        } else {
            return  redirect()->back()->with('error', "Unable to Change Password");
        }
    }
    public function user_permission()
    {
        $this->data['users'] = User::latest()->get();
        $this->data['active'] = 'user_permission';
        return view('admin.permissions', $this->data);
    }
    public function manage_permission($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (empty($user)) {
            abort(404);
        }
        $permissions = Permissions::all();
        $user_permissions = UserPermissions::where('user_id', $user->id)->get();


        $checked = [];
        $given_permissions = [];
        if (!$user_permissions->isEmpty()) {
            foreach ($user_permissions as $key => $user_permission) {
                $given_permissions[] =  $user_permission->permission_id;
            }
        }
        foreach ($permissions as $key => $permission) {
            if (in_array($permission->id, $given_permissions)) {
                $checked[$permission->id] = "checked";
            } else {
                $checked[$permission->id] = "";
            }
        }
        $this->data['user'] = $user;
        $this->data['permissions'] = $permissions;
        $this->data['checked'] = $checked;
        $this->data['active'] = 'setting';
        return view('admin.manage_permissions', $this->data);
    }

    public function update_permission(Request $request)
    {
        $user_id = $request->user_id;
        $permission  = $request->id;
        $value = $request->checked;
        if ($value == 'false') {
            $user_permission = UserPermissions::where(['user_id' => $user_id, 'permission_id' => $permission])->first();
            $user_permission->delete();
            $message = ['message' => 'Permission Denied', 'class' => 'warning'];
        } elseif ($value == 'true') {
            UserPermissions::create(['user_id' => $user_id, 'permission_id' => $permission]);
            $message = ['message' => 'Permission Granted', 'class' => 'success'];
        } else {
            $message = ['message' => 'Error!! ', 'class' => 'error'];
        }
        echo json_encode($message);
    }
    public function trash()
    {
        $items = [
            ['name' => 'Products', 'model' => 'products'],
            ['name' => 'Shops', 'model' => 'shops'],
            ['name' => 'Sales', 'model' => 'sales'],
            ['name' => 'Purchases', 'model' => 'purchases'],
            ['name' => 'Users', 'model' => 'users'],
            ['name' => 'Customers', 'model' => 'customers'],
            ['name' => 'Suppliers', 'model' => 'suppliers']
        ];
        $count = [];
        foreach ($items as $key => $item) {
            if ($item['name'] == 'Shops' || $item['name'] == 'Users') {
                $where = '';
            } else {
                $where = 'AND shop_id =' . session('shop_id');
            }
            $count[$item['name']] = DB::select(" select count(*) as count from " . $item['model'] . " where deleted_at is not null " . $where);
        }
        $this->data['count'] = $count;
        $this->data['items'] = $items;
        $this->data['active'] = 'trash';
        return view('restore.trash', $this->data);
    }

    public function restore($item)
    {

        $items = [
            'Products',
            'Shops',
            'Sales',
            'Purchases',
            'Users',
            'Customers',
            'Suppliers'
        ];
        if (!in_array($item, $items)) {
            abort(403);
        } else {
            $this->data['active'] = 'trash';
            switch ($item) {
                case 'Products':
                    $products = Product::where('shop_id', session('shop_id'))->onlyTrashed()->get();
                    $this->data['products'] = $products;
                    return view('restore.product', $this->data);
                    break;

                case 'Shops':
                    $shops = Shop::onlyTrashed()->get();
                    $this->data['shops'] = $shops;
                    return view('restore.shop', $this->data);
                    break;

                case 'Sales':
                    $sales = sale::where('shop_id', session('shop_id'))->onlyTrashed()->get();
                    $this->data['sales'] = $sales;
                    $payment = [];
                    if (!$sales->isEmpty()) {
                        foreach ($sales as $key => $sale) {
                            $payment[$sale->id] =  $sale->payment->sum('amount');
                        }
                    }
                    $this->data['payments'] = $payment;
                    return view('restore.sales', $this->data);
                    break;

                case 'Purchases':
                    $purchases = Purchase::where('shop_id', session('shop_id'))->onlyTrashed()->get();
                    $payment = [];
                    if (!$purchases->isEmpty()) {
                        foreach ($purchases as $key => $purchase) {
                            $payment[$purchase->id] =  $purchase->payment->sum('amount');
                        }
                    }
                    $this->data['payments'] = $payment;
                    $this->data['purchases'] = $purchases;
                    return view('restore.purchases', $this->data);
                    break;

                case 'Users':
                    $users = User::onlyTrashed()->get();
                    $this->data['users'] = $users;
                    return view('restore.users', $this->data);
                    break;

                case 'Customers':
                    $this->data['customers'] = Customer::where(['shop_id' => session('shop_id')])->onlyTrashed()->get();
                    return view('restore.customers', $this->data);
                    break;

                case 'Suppliers':
                    $this->data['suppliers'] = Supplier::where(['shop_id' => session('shop_id')])->onlyTrashed()->get();
                    return view('restore.suppliers', $this->data);
                    break;

                default:
                    return view('errors.404');
                    break;
            }
        }
    }

    public function restoreProduct(Request $request)
    {
        $id = $request->id;
        $product = Product::withTrashed()->find($id);
        if (!empty($product)) {
            $product->restore();
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }

        echo json_encode($response);
    }
    public function delete_product(Request $request)
    {
        $id = $request->id;
        $product = Product::withTrashed()->find($id);
        if (!empty($product)) {
            $product->forceDelete();
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response =
                [
                    'title' => 'Failed!',
                    'message' => 'Error!!'
                ];
        }
        echo json_encode($response);
    }

    public function restoreShop(Request $request)
    {
        $id = $request->id;
        $shop = Shop::withTrashed()->find($id);
        if (!empty($shop)) {
            $shop->restore();
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_shop(Request $request)
    {
        $id = $request->id;
        $shop = Shop::withTrashed()->find($id);
        if (!empty($shop)) {
            $shop->forceDelete();
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response =
                [
                    'title' => 'Failed!',
                    'message' => 'Error!!'
                ];
        }
        echo json_encode($response);
    }

    public function restoreUser(Request $request)
    {
        $id = $request->id;
        $User = User::withTrashed()->find($id);
        if (!empty($User)) {
            $User->restore();
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_user(Request $request)
    {
        $id = $request->id;
        $User = User::withTrashed()->find($id);
        if (!empty($User)) {
            $User->forceDelete();
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response =
                [
                    'title' => 'Failed!',
                    'message' => 'Error!!'
                ];
        }
        echo json_encode($response);
    }

    public function restoreCustomer(Request $request)
    {
        $id = $request->id;
        $customer = Customer::withTrashed()->find($id);
        if (!empty($customer)) {
            $customer->restore();
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_customer(Request $request)
    {
        $id = $request->id;
        $customer = Customer::withTrashed()->find($id);
        if (!empty($customer)) {
            $customer->forceDelete();
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }


    public function restoreSupplier(Request $request)
    {
        $id = $request->id;
        $supplier = Supplier::withTrashed()->find($id);
        if (!empty($supplier)) {
            $supplier->restore();
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_supplier(Request $request)
    {
        $id = $request->id;
        $supplier = Supplier::withTrashed()->find($id);
        if (!empty($supplier)) {
            $supplier->forceDelete();
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function restorePurchase(Request $request)
    {
        $id = $request->id;
        $purchase = Purchase::withTrashed()->find($id);
        if (!empty($purchase)) {
            $purchase->restore();
            $products = PurchaseProduct::where('purchase_id', $purchase->id)->withTrashed()->get();
            if (!$products->isEmpty()) {
                foreach ($products as $key => $product) {
                    $product->restore();
                }
            }

            $payments = Payment::where('purchase_id', $purchase->id)->withTrashed()->get();
            if (!$payments->isEmpty()) {
                foreach ($payments as $key => $payment) {
                    $payment->restore();
                }
            }

            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_purchase(Request $request)
    {
        $id = $request->id;
        $purchase = Purchase::withTrashed()->find($id);
        if (!empty($purchase)) {
            $purchase->forceDelete();
            $products = PurchaseProduct::where('purchase_id', $purchase->id)->withTrashed()->get();
            if (!$products->isEmpty()) {
                foreach ($products as $key => $product) {
                    $product->forceDelete();
                }
            }
            $payments = Payment::where('purchase_id', $purchase->id)->withTrashed()->get();
            if (!$payments->isEmpty()) {
                foreach ($payments as $key => $payment) {
                    $payment->forceDelete();
                }
            }
            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function restoreSale(Request $request)
    {
        $id = $request->id;
        $sale = Sale::withTrashed()->find($id);
        if (!empty($sale)) {
            $sale->restore();
            $products = SaleProduct::where('sale_id', $sale->id)->withTrashed()->get();
            if (!$products->isEmpty()) {
                foreach ($products as $key => $product) {
                    $product->restore();
                }
            }
            $payments = Payment::where('sale_id', $sale->id)->withTrashed()->get();
            if (!$payments->isEmpty()) {
                foreach ($payments as $key => $payment) {
                    $payment->restore();
                }
            }
            $response = [
                'title' => 'Restored!',
                'message' => 'Restored Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }

    public function delete_sale(Request $request)
    {
        $id = $request->id;
        $sale = Sale::withTrashed()->find($id);
        if (!empty($sale)) {
            $sale->forceDelete();
            $products = SaleProduct::where('sale_id', $sale->id)->withTrashed()->get();
            if (!$products->isEmpty()) {
                foreach ($products as $key => $product) {
                    $product->forceDelete();
                }
            }
            $payments = Payment::where('sale_id', $sale->id)->withTrashed()->get();
            if (!$payments->isEmpty()) {
                foreach ($payments as $key => $payment) {
                    $payment->forceDelete();
                }
            }

            $response = [
                'title' => 'Deleted!',
                'message' => 'Deleted Successfully'
            ];
        } else {
            $response = [
                'title' => 'Failed!',
                'message' => 'Error!!'
            ];
        }
        echo json_encode($response);
    }
    public function depreciation()
    {
        // cost of item = 1,000,000
        $cost = 1000000;
        //    depreciation percentage = 10%
        $percentage = 10;
        $depreciation_percentage = ($percentage / 100);
        //    date of purchase = '2022-04-15';

        $date_purchase = '2022-04-15';
        // number of years from the date of purchase
        // since we count from the start and end of the year
        $year = date('Y', strtotime($date_purchase));
        $startDate = $year . '-01-01';
        $endDate = date('Y-12-31');


        $startDate = Carbon::createFromDate($startDate);

        $numberOfYears = $startDate->diffInYears($endDate);
        //  we add one to get exact number of years between date range
        $numberOfYears = $numberOfYears + 1;
        //  at starting point
        $depreciation = 0;
        $nbv = 0;
        //  Loop through number of years to calculate depreciation and NBV
        for ($i = 1; $i <= $numberOfYears; $i++) {
            $depreciation += $cost * $depreciation_percentage;
            $nbv = ($cost - $depreciation);
        }
        return [
            'origin cost' => $cost,
            'accumulative depreciation' => $depreciation,
            'net book value' => $nbv
        ];
    }

    public function calculate_depreciation($cost, $percentage, $date_purchase = null, $after_years = null)
    {
        $depreciation_percentage = ($percentage / 100);
        if ($after_years != NULL) {
            $numberOfYears = $after_years;
        } else {
            $year = date('Y', strtotime($date_purchase));
            $startDate = $year . '-01-01';
            $endDate = date('Y-12-31');


            $startDate = Carbon::createFromDate($startDate);

            $numberOfYears = $startDate->diffInYears($endDate);
            //  we add one to get exact number of years between date range
            $numberOfYears = $numberOfYears + 1;
        }

        $depreciation = 0;
        $nbv = 0;
        for ($i = 1; $i <= $numberOfYears; $i++) {
            $depreciation += $cost * $depreciation_percentage;
            $nbv = ($cost - $depreciation);
        }
        return [
            'origin cost' => $cost,
            'accumulative depreciation' => $depreciation,
            'net book value' => $nbv
        ];
    }

    // units
    public function units()
    {
        $this->data['active'] = 'units';
        return view('admin.units', $this->data);
    }
    public function get_units()
    {
        $this->data['units'] = Unit::orderBy('name')->get();
        return view('admin.unit_content', $this->data);
    }

    public function addunit()
    {
        $data = request()->except(['_token', 'unit_id']);
        $unit =  Unit::create($data);
        if ($unit) {
            $response = [
                'type' => "Success",
                'title' => 'Success!',
                'message' => 'Unit Added Successfully'
            ];
        } else {
            $response = [
                'type' => "Error",
                'title' => 'Failed!',
                'message' => 'Unit not Added'
            ];
        }
        echo json_encode($response);
    }
    public function deleteunit()
    {
        $id = request('unit_id');
        $unit = Unit::find($id);
        if (count($unit->product) > 0) {
            $response = [
                'title' => 'Failed!',
                'message' => 'There are some products that are measured in this unit, This this unit can\'t be deleted. You need to delete those products first'
            ];
        } else {

            $deleted = $unit->delete();
            if ($deleted) {
                $response = [
                    'title' => 'Success!',
                    'message' => 'Unit Deleted Successfully'
                ];
            } else {
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Unit not deleted'
                ];
            }
        }
        echo json_encode($response);
    }
    public function fetchunit()
    {
        $id = $_GET['id'];
        $unit = Unit::find($id);
        if (!empty($unit)) {
            echo json_encode($unit);
        }
    }

    public function updateunit()
    {
        $id = request('unit_id');
        $unit = Unit::find($id);
        if (!empty($unit)) {
            $data = request()->except(['_token', 'unit_id']);
            $unit->update($data);
            $response = [
                'type' => "Success",
                'title' => 'Success!',
                'message' => 'Unit Updated Successfully'
            ];
        } else {
            $response = [
                'type' => "Error",
                'title' => 'Failed!',
                'message' => 'Unit not Updated'
            ];
        }
        echo json_encode($response);
    }

    //categories
    public function Category()
    {
        $this->data['categories'] = Category::orderBy('name')->get();
        $this->data['active'] = 'categories';
        return view('admin.category', $this->data);
    }

    public function addCategory()
    {
        $data = request()->except(['_token', 'category_id']);
        $category =  Category::create($data);
        if ($category) {
            $response = [
                'type' => "Success",
                'title' => 'Success!',
                'message' => 'Category Added Successfully'
            ];
        } else {
            $response = [
                'type' => "Error",
                'title' => 'Failed!',
                'message' => 'Category not Added'
            ];
        }
        echo json_encode($response);
    }
    public function deleteCategory()
    {
        $id = request('category_id');
        $deleted = Category::where('id', $id)->delete();
        if ($deleted) {
            $response = [
                'message' => 'Category Deleted Successfully'
            ];
        } else {
            $response = [
                'message' => 'Category not deleted'
            ];
        }
        echo json_encode($response);
    }
    public function fetchCategory()
    {
        $id = $_GET['id'];
        $category = Category::find($id);
        if (!empty($category)) {
            echo json_encode($category);
        }
    }

    public function updateCategory()
    {
        $id = request('category_id');
        $category = Category::find($id);
        if (!empty($category)) {
            $data = request()->except(['_token', 'category_id']);
            $category->update($data);
            $response = [
                'type' => "Success",
                'title' => 'Success!',
                'message' => 'Category Updated Successfully'
            ];
        } else {
            $response = [
                'type' => "Error",
                'title' => 'Failed!',
                'message' => 'Category not Updated'
            ];
        }
        echo json_encode($response);
    }
}
