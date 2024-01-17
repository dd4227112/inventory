<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;

Route::middleware(['auth', 'verify_shop'])->group(function () {
    Route::post('/restoreProduct', [Admin::class, 'restoreProduct']);
    Route::post('/delete_product', [Admin::class, 'delete_product']);

    Route::post('/restoreShop', [Admin::class, 'restoreShop']);
    Route::post('/delete_shop', [Admin::class, 'delete_shop']);

    Route::post('/restoreUser', [Admin::class, 'restoreUser']);
    Route::post('/delete_user', [Admin::class, 'delete_user']);

    Route::post('/restoreCustomer', [Admin::class, 'restoreCustomer']);
    Route::post('/delete_customer', [Admin::class, 'delete_customer']);
    
    Route::post('/restoreSupplier', [Admin::class, 'restoreSupplier']);
    Route::post('/delete_supplier', [Admin::class, 'delete_supplier']);

    Route::post('/restorePurchase', [Admin::class, 'restorePurchase']);
    Route::post('/delete_purchase', [Admin::class, 'delete_purchase']);

    Route::post('/restoreSale', [Admin::class, 'restoreSale']);
    Route::post('/delete_sale', [Admin::class, 'delete_sale']);
    
});
