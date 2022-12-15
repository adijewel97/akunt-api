<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TestOracleControler;
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

Route::get('/transaction', [TransactionController::class, 'index']);
Route::post('/transaction/store', [TransactionController::class, 'store']);
Route::get('/transaction/show/{id}', [TransactionController::class, 'show']);
Route::post('/transaction/update/{id}', [TransactionController::class, 'update']);
Route::delete('/transaction/destroy/{id}', [TransactionController::class, 'destroy']);

Route::get('/oracletest', [TestOracleControler::class, 'index']);
Route::get('/oracletest/testfunctioncurku', [TestOracleControler::class, 'testfunctioncur']);
Route::get('/oracletest/testfunctioncur2', [TestOracleControler::class, 'testfunctioncur2']);
