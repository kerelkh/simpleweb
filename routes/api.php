<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\GenerateNumberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/oddevenphone', [PhoneNumberController::class, 'getOddEvenPhone']);
Route::get('/phone', [GenerateNumberController::class, 'getRandomPhoneNumber']);
Route::get('/phonenumber', [PhoneNumberController::class, 'getPhoneNumber']);
Route::post('/update', [PhoneNumberController::class, 'updatePhoneNumber']);