<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/shops', [Admin::class, 'shop'])->name('admin.list_shop');
Route::post('/store_shop', [Admin::class, 'store_shop'])->name('admin.store_shop');
Route::get('/addshop', [Admin::class, 'addshop'])->name('admin.add_shop');
Route::get('/fetchshop/{shop}', [Admin::class, 'fetchshop'])->name('admin.fetchshop');
Route::post('/updateshop', [Admin::class, 'updateshop'])->name('admin.update_shop');
Route::post('/deleteshop', [Admin::class, 'deleteshop'])->name('admin.deleteshop');