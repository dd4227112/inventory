<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('authentication.login');
});

Route::get('/sales', function () {
    return view('sales.index');
})->middleware(['auth', 'verified'])->name('sales');


// Route::get('/admin', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified'])->name('admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Admin
    Route::get('/admin', [Admin::class, 'index'])->name('admin');
    Route::post('/home', [Admin::class, 'home'])->name('admin.home');
    Route::get('/dashboard', [Admin::class, 'dashboard'])->name('admin.dashboard');


    //users
    
    Route::get('/users', [Admin::class, 'user'])->name('admin.list_user');
    Route::get('/store', [Admin::class, 'store'])->name('admin.store_user');

    Route::get('/addUser', [Admin::class, 'addUser'])->name('admin.add_user');
    Route::post('/viewUser', [Admin::class, 'viewUser'])->name('admin.view_user');
    Route::post('/getUser', [Admin::class, 'getUser'])->name('admin.get_user');
    Route::post('/updateUser', [Admin::class, 'updateUser'])->name('admin.update_user');
    Route::post('/deleteUser', [Admin::class, 'deleteUser'])->name('admin.delete_user');



    

    


});

require __DIR__.'/auth.php';
