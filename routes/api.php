<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ItemController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API Routes
//Account
Route::post("register", [AccountController::class, "register"]);
Route::post("login", [AccountController::class, "login"]);

Route::group([
    //"middleware" => ["auth:api"]
], function () {
    Route::get("profile", [AccountController::class, "profile"]);
    Route::get("refresh", [AccountController::class, "refreshToken"]);
    Route::get("logout", [AccountController::class, "logout"]);
    //Items
    Route::get("item/all", [ItemController::class, "get"]);
    Route::post("item/add", [ItemController::class, "store"]);
    Route::get("item/search/{id}", [ItemController::class, "search"]);
    Route::put("item/update/{id}", [ItemController::class, "update"]);
    Route::delete("item/delete/{id}", [ItemController::class, "delete"]);
});
