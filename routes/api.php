<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return response()->json(['status' => 'OK']);
});

Route::get('/protected-test', function (){
    return response()->json(['message' => 'You are verified']);
})->middleware('firebase');

Route::middleware(['firebase'])->group(function (){
// put all protected api here for protection


});

Route::get('/auth/lazada/redirect', [LazadaAuthController::class, 'redirect']);
Route::get('/auth/lazada/callback', [LazadaAuthController::class, 'callback']);