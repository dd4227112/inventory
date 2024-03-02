<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::middleware(['auth'])->group(function () {
    Route::get('/category', [Admin::class, 'category'])->name('admin.list_category');
    Route::post('/store_category', [Admin::class, 'store_category'])->name('admin.store_category');
    Route::post('/addcategory', [Admin::class, 'addcategory'])->name('admin.add_category');
    Route::get('/fetchcategory', [Admin::class, 'fetchcategory'])->name('admin.fetchcategory');
    Route::post('/updatecategory', [Admin::class, 'updatecategory'])->name('admin.update_category');
    Route::post('/deletecategory', [Admin::class, 'deletecategory'])->name('admin.deletecategory');
});
