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
   Route::post('/deletepayment', [PaymentController::class, 'deletepayment'])->name('delete_payment');
});
