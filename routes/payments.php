<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
//payments
Route::middleware(['auth', 'verify_shop'])->group(function () {
   Route::get('/payments', [paymentController::class, 'index'])->name('list_payment');
   Route::get('/addpayment', [PaymentController::class, 'addpayment'])->name('add_payment');
   Route::post('/storepayment', [PaymentController::class, 'store'])->name('store_payment');
   Route::post('/viewpayment', [PaymentController::class, 'viewpayment'])->name('view_payment');
   Route::post('/getpayment', [PaymentController::class, 'getpayment'])->name('get_payment');
   Route::post('/updatepayment', [PaymentController::class, 'updatepayment'])->name('update_payment');
   Route::post('deletepayment', [PaymentController::class, 'deletepayment']);
   Route::post('/deletepurchasepayment', [PaymentController::class, 'deletepurchasepayment']);
   Route::get('/salepaymentreceipt/{payment}', [PaymentController::class, 'salepaymentreceipt'])->name('sale_payment_receipt');
   Route::get('/purchasepaymentreceipt/{payment}', [PaymentController::class, 'purchasepaymentreceipt'])->name('purchase_payment_receipt');
   

   
   Route::post('getsinglepayment', [PaymentController::class, 'getSinglePayment']); 
   Route::post('getSinglePurchasePayment', [PaymentController::class, 'getSinglePurchasePayment']); 
   Route::post('/updatePurchasePayment', [PaymentController::class, 'updatePurchasePayment'])->name('updatePurchasePayment');



   
});

Route::get('/previewpayment', [PaymentController::class, 'previewpayment'])->name('previewpayment');
Route::get('/previewpurchase', [PaymentController::class, 'previewpurchase'])->name('previewpurchase');

