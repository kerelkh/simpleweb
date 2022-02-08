<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\AddPhoneNumberController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// authentication
Route::middleware('guest')->group(function(){
    Route::get('/', [LoginController::class, 'login'])->name('auth.login');
    Route::get('/auth/redirect', [LoginController::class, 'redirectToProvider']);
    Route::get('/auth/callback', [LoginController::class, 'handleProviderCallback']);
});

//main
Route::middleware('auth')->group(function(){
    Route::post('/logout', LogoutController::class)->name('auth.logout');
    Route::get('/input', [HomeController::class, 'input'])->name('index.input');
    Route::get('/output', [HomeController::class, 'output'])->name('index.output');
    Route::post('/addphone', [AddPhoneNumberController::class, 'addPhoneNumber'])->name('add.phone');
    Route::delete('/delete', [PhoneNumberController::class, 'deletePhoneNumber'])->name('delete.phone');
});

Route::fallback(function(){
    return redirect()->route('auth.login');
});
