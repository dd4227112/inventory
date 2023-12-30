<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
//purchases
Route::middleware(['auth', 'verify_shop'])->group(function () {
   Route::get('/purchases', [PurchaseController::class, 'index'])->name('list_purchase');
   Route::get('/addpurchase', [PurchaseController::class, 'addpurchase'])->name('add_purchase');
   Route::post('/storepurchase', [PurchaseController::class, 'store'])->name('store_purchase');
   Route::get('/viewpurchase/{purchase}', [PurchaseController::class, 'viewpurchase'])->name('view_purchase');
   Route::post('/getpurchase', [PurchaseController::class, 'getpurchase'])->name('get_purchase');
   Route::post('/updatepurchase', [PurchaseController::class, 'updatepurchase'])->name('update_purchase');
   Route::post('/deletepurchase', [PurchaseController::class, 'deletepurchase'])->name('delete_purchase');
   Route::post('/fetch_purchase', [PurchaseController::class, 'fetch_purchase'])->name('get_purchase'); //get selected product on adding purchase via ajax request
   Route::post('/singlePurchasePayment', [PurchaseController::class, 'singlePurchasePayment']);
   Route::post('/purchase_payment_receipt', [PurchaseController::class, 'purchase_payment_receipt']);
   Route::get('/editpurchase/{purchase}', [PurchaseController::class, 'editpurchase'])->name('edit_purchase');
   Route::get('/printpurchase/{purchase}', [PurchaseController::class, 'printpurchase'])->name('print_purchase');

    
   




   


   
   
});
