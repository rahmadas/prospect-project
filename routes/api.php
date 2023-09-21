<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\ContactCategory\ContactCategoryController;
use App\Http\Controllers\ContactMessage\ContactMessageController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\MessageTemplate\MessageTemplateController;
use App\Http\Controllers\ProFeature\ProFeatureController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UserProFeature\UserProFeatureController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);





Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'show']);

    Route::apiResource('/contact', ContactController::class);
    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/contact-category', ContactCategoryController::class);
    Route::apiResource('/message', MessageController::class);
    Route::apiResource('/message-template', MessageTemplateController::class);
    Route::apiResource('/contact-message', ContactMessageController::class);
    Route::apiResource('/pro-feature', ProFeatureController::class);
    Route::apiResource('/user-pro-feature', UserProFeatureController::class);

    Route::post('/logout', [LogoutController::class, 'logout']);
});












Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
