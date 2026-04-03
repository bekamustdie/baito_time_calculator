<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\BaitoController;
use App\Http\Controllers\Api\V1\AuthController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify', function () {
    return response()->json([
        'message'=>'Please verify your email'
    ], 403)->middleware('auth')->name('verification.notice');
    });
Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('users', UsersController::class);
        Route::apiResource('baitos', BaitoController::class);
        //get baitos for month
        Route::get('/baitos/month/{year}/{month}', [BaitoController::class, 'getByMonth']);
        //get baitos for week 
        Route::get('/baitos/week/{date}', [BaitoController::class, 'getByWeek']);
        //get baitos for one day 
        Route::get('/baitos/day/{date}', [BaitoController::class, 'getByDay']);

        Route::patch('/baitos/{baito}/complete', [BaitoController::class, 'markAsCompleted']);
    });
});




