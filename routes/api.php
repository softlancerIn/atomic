<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

use function Ramsey\Uuid\v1;

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

//=================================  api ===========================================//
Route::post('/v1', [WebController::class, 'auth'])->name('authPage');
Route::post('/v1/payout/', [WebController::class, 'payout'])->name('payout');
Route::post('/v1/refund-status/', [WebController::class, 'refundStatus'])->name('refundStatus');
//=================================  api ===========================================//
