<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\BaitoController;
use App\Http\Controllers\Api\V1\AuthController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/users', function (Request $request) {
            return $request->user();});
        Route::apiResource('users', UsersController::class);
        // Route::apiResource('users.baitos', BaitoController::class)->scoped();
        Route::apiResource("baitos", BaitoController::class);
    });
});




