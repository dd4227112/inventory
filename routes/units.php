<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::middleware(['auth'])->group(function () {
    Route::get('/units', [Admin::class, 'units'])->name('admin.list_units');
    Route::post('/store_units', [Admin::class, 'store_units'])->name('admin.store_units');
    Route::post('/addunit', [Admin::class, 'addunit'])->name('admin.add_unit');
    Route::get('/fetchunit', [Admin::class, 'fetchunit'])->name('admin.fetchunit');
    Route::post('/updateunit', [Admin::class, 'updateunit'])->name('admin.update_unit');
    Route::post('/deleteunit', [Admin::class, 'deleteunit'])->name('admin.deleteunit');
    Route::get('/get_units', [Admin::class, 'get_units'])->name('admin.get_units');

    
});
