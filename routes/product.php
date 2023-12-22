
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::middleware(['auth', 'verify_shop'])->group(function () {
    Route::get('/index', [ProductController::class, 'index'])->name('list_product');
    Route::post('/store_product', [ProductController::class, 'store_product'])->name('store_product');
    Route::get('/addproduct', [ProductController::class, 'addproduct'])->name('add_product');
    Route::get('/getProduct/{search}', [ProductController::class, 'getProduct']);
    Route::post('/fetch_product', [ProductController::class, 'fetch_product']);
});
