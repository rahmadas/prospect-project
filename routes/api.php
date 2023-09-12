<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\ContactCategory\ContactCategoryController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login'] );
Route::post('/logout', [LogoutController::class, 'logout']);


Route::apiResource('/contact', ContactController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/contact-category', ContactCategoryController::class);
Route::apiResource('/message', MessageController::class);



Route::group(['middleware' => 'auth:sanctum'], function () 
{

    Route::post('/logout', [LogoutController::class, 'logout']);
});

Route::get('/user', [UserController::class, 'show']);

//









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

