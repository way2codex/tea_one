<?php

use App\Http\Controllers\ApiController;
use App\Models\CustomerMaster;
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

Route::get('/customer_list', [ApiController::class, 'customer_list']);
Route::post('/store_entry', [ApiController::class, 'store_entry']);
Route::post('/entry_report', [ApiController::class, 'entry_report']);