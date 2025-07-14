<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MidtransController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/paket/{paket}/check-quota', [OrderController::class, 'checkQuota'])->name('api.quota.check');
<<<<<<< HEAD
// Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification']);
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification']);
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification']);
=======
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');
>>>>>>> af162f85b0ead4ae875514615846c3a05799e27c
Route::get('/midtrans/finish', [MidtransController::class, 'finish']);
