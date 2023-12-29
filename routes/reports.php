<?php

use App\Http\Controllers\Reports;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verify_shop'])->group(function () { 

    Route::get('/salesreport', [Reports::class, 'salesreport'])->name('salesreport');
    Route::get('/purchasereport', [Reports::class, 'purchasereport'])->name('purchasereport');
    Route::get('/inventoryreport', [Reports::class, 'inventoryreport'])->name('inventoryreport');
    Route::get('/productreport', [Reports::class, 'productreport'])->name('productreport');
    Route::get('/productSale/{product}', [Reports::class, 'productSale'])->name('productSale');
    Route::get('/productPurchase/{product}', [Reports::class, 'productPurchase'])->name('productPurchase');
    Route::get('/combinedProduct/{product}', [Reports::class, 'combinedProduct'])->name('combinedProduct');



    


    

});