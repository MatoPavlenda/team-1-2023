<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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


Route::get('/not-logged-in', [\App\Http\Controllers\Authentication\AuthController::class, 'unauthorized'])->name('notLoggedIn');
Route::get('/no-permission', [\App\Http\Controllers\Authentication\AuthController::class, 'noPermission'])->name('noPermission');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lol', function () {
    echo 22;
});

Route::get('/overkill2', [TestController::class, 'overkillMethod']);