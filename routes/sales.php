<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
   //sales
   Route::get('/sales', [SaleController::class, 'index'])->name('list_sale');
   Route::get('/addsale', [SaleController::class, 'addsale'])->name('add_sale');
   Route::post('/storesale', [SaleController::class, 'store'])->name('store_sale');
   Route::post('/viewsale', [SaleController::class, 'viewsale'])->name('view_sale');
   Route::post('/getsale', [SaleController::class, 'getsale'])->name('get_sale');
   Route::post('/updatesale', [SaleController::class, 'updatesale'])->name('update_sale');
   Route::post('/deletesale', [SaleController::class, 'deletesale'])->name('delete_sale');