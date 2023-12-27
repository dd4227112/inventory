<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
//sales
Route::middleware(['auth', 'verify_shop'])->group(function () {
   Route::get('/list_sale', [SaleController::class, 'index'])->name('list_sale');
   Route::get('/addsale', [SaleController::class, 'addsale'])->name('add_sale');
   Route::post('/storesale', [SaleController::class, 'store'])->name('store_sale');
   Route::get('/viewsale/{id}', [SaleController::class, 'viewsale'])->name('view_sale');
   Route::post('/getsale', [SaleController::class, 'getsale'])->name('get_sale');
   Route::post('/updatesale', [SaleController::class, 'updatesale'])->name('update_sale');
   Route::post('/deletesale', [SaleController::class, 'destroy']);
   Route::post('/getsalepayment', [SaleController::class, 'salepayment']);
   Route::post('/savesalepayment', [SaleController::class, 'savepayment'])->name('store_sale_payment');
   Route::get('/edit_sales/{id}', [SaleController::class, 'edit'])->name('edit_sale');
   Route::post('/singleSalePayment', [SaleController::class, 'singleSalePayment'])->name('singleSalePayment');
   Route::get('/printsale/{sale}', [SaleController::class, 'print'])->name('print_sale');

});
