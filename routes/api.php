<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;

//Autenticacion
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

//--- Usuarios ---
Route::get("/obtenerCorreos", [UserController::class, "obtenerCorreos"]);




//Rutas protegidas
Route::group(["middleware"=>["auth:sanctum"]], function(){

    //Auth
    Route::post("/logout", [AuthController::class, "logout"]);

    /// --- Codigos ---
    Route::put("/code/scan", [CodeController::class, "scanCode"]);
    Route::post("/code", [CodeController::class, "store"]);
    Route::get("/code/{code}", [CodeController::class, "show"]);
    Route::put("/code/{code}", [CodeController::class, "update"]);
    Route::delete("/code/{code}", [CodeController::class, "destroy"]);
    route::get("/codes", [CodeController::class, "index"] );
});
