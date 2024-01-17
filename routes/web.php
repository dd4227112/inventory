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
    return view('sales.dashboard');
})->middleware(['auth', 'verified'])->name('sales');


// Route::get('/admin', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified'])->name('admin');

Route::middleware(['auth', 'verify_shop'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Admin

    Route::get('/dashboard', [Admin::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [Admin::class, 'index'])->name('admin');
    Route::post('/home', [Admin::class, 'home'])->name('admin.home');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/product.php';
require __DIR__ . '/shop.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/sales.php';
require __DIR__ . '/purchases.php';
require __DIR__ . '/payments.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/restore.php';



// Could not move the file "/tmp/phpMCtLGE" to "/var/www/html/Inventory_Management/public/uploads/profiles/Screenshot from 2023-12-27 16-28-17.png" (move_uploaded_file(): Unable to move &quot;/tmp/phpMCtLGE&quot; to
