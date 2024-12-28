<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CodigoController;
use App\Http\Controllers\Api\UsuarioController;

//Autenticacion
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

//--- Usuarios ---
Route::get("/obtenerCorreos", [UsuarioController::class, "obtenerCorreos"]);




//Rutas protegidas
Route::group(["middleware"=>["auth:sanctum"]], function(){

    //Auth
    Route::post("/logout", [AuthController::class, "logout"]);

    /// --- Codigos ---
    Route::put("/codigo/escanear", [CodigoController::class, "escanear"]);
    Route::post("/codigo", [CodigoController::class, "store"]);
    Route::get("/codigo/{codigo}", [CodigoController::class, "show"]);
    Route::put("/codigo/{codigo}", [CodigoController::class, "update"]);
    Route::delete("/codigo/{codigo}", [CodigoController::class, "destroy"]);
    route::get("/codigos", [CodigoController::class, "index"] );
});
