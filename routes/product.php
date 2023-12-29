
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::middleware(['auth', 'verify_shop'])->group(function () {
    Route::get('/index', [ProductController::class, 'index'])->name('list_product');
    Route::post('/store_product', [ProductController::class, 'store_product'])->name('store_product');
    Route::get('/addproduct', [ProductController::class, 'addproduct'])->name('add_product');
    Route::get('/getSaleProduct/{search}', [ProductController::class, 'getSaleProduct']);
    Route::post('/fetch_product', [ProductController::class, 'fetch_product']);
    Route::get('/edit_product/{product}', [ProductController::class, 'edit'])->name('edit_product');
    Route::get('/getPurchaseProduct/{search}', [ProductController::class, 'getPurchaseProduct']);
    Route::post('/updateProduct', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::post('/deleteproduct', [ProductController::class, 'deleteproduct']); 

});
