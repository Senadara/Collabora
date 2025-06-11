<?php

use App\Http\Controllers\Api\EventApiController;
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

Route::prefix('events')->group(function () {
    Route::get('/', [EventApiController::class, 'index']);               // GET: /api/events
    Route::get('/{id}', [EventApiController::class, 'show']);            // GET: /api/events/{id}
    Route::put('/{id}', [EventApiController::class, 'update']);          // PUT: /api/events/{id}
});
