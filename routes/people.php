<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;

Route::middleware('auth')->group(function () {
    Route::get('/users', [Admin::class, 'user'])->name('admin.list_user');
    Route::post('/store', [Admin::class, 'store'])->name('admin.store_user');

    Route::get('/addUser', [Admin::class, 'addUser'])->name('admin.add_user');
    Route::post('/viewUser', [Admin::class, 'viewUser'])->name('admin.view_user');
    Route::post('/getUser', [Admin::class, 'getUser'])->name('admin.get_user');
    Route::post('/updateUser', [Admin::class, 'updateUser'])->name('admin.update_user');
    Route::post('/deleteUser', [Admin::class, 'deleteUser'])->name('admin.delete_user');

    //customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('list_customer');
    Route::get('/addcustomer', [CustomerController::class, 'addcustomer'])->name('add_customer');
    Route::post('/storecustomer', [CustomerController::class, 'store'])->name('store_customer');
    Route::post('/viewcustomer', [CustomerController::class, 'viewcustomer'])->name('view_customer');
    Route::get('/getcustomer', [CustomerController::class, 'getcustomer'])->name('get_customer');
    Route::post('/updatecustomer', [CustomerController::class, 'updatecustomer'])->name('update_customer');
    Route::post('/deletecustomer', [CustomerController::class, 'deletecustomer'])->name('delete_customer');

    //suppliers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('list_supplier');
    Route::get('/addsupplier', [SupplierController::class, 'addsupplier'])->name('add_supplier');
    Route::post('/storesupplier', [SupplierController::class, 'store'])->name('store_supplier');
    Route::post('/viewsupplier', [SupplierController::class, 'viewsupplier'])->name('view_supplier');
    Route::get('/getsupplier', [SupplierController::class, 'getsupplier'])->name('get_supplier');
    Route::post('/updatesupplier', [SupplierController::class, 'updatesupplier'])->name('update_supplier');
    Route::post('/deletesupplier', [SupplierController::class, 'deletesupplier'])->name('delete_supplier');
});
