<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AmenityController;

use App\Http\Controllers\Api\AmenityReservationController;


//--- Auth ---
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

//--- Users ---
Route::get("/getAccounts", [UserController::class, "getAccounts"]);




//--- Protected routes ---
Route::group(["middleware"=>["auth:sanctum"]], function(){

    //--- Auth ---
    Route::post("/logout", [AuthController::class, "logout"]);

    /// --- Codigos ---
    Route::put("/code/scan", [CodeController::class, "scanCode"]);
    Route::post("/code", [CodeController::class, "store"]);
    Route::get("/code/{code}", [CodeController::class, "show"]);
    Route::put("/code/{code}", [CodeController::class, "update"]);
    Route::delete("/code/{code}", [CodeController::class, "destroy"]);
    route::get("/codes", [CodeController::class, "index"] );

    // --- Amenities ---
    //        NOTE: dont use, we populated the database manually,
    //        but in future it will be util
    Route::get("/amenities", [AmenityController::class], "index");
    Route::post("/amenity", [AmenityController::class], "store");
    Route::get("/amenity/{Amenity}", [AmenityController::class], "show");
    Route::put("/amenity/{Amenity}", [AmenityController::class], "update");
    Route::delete("/amenity/{Amenity}", [AmenityController::class], "destroy");


    // --- Amenity Reservations ---
    Route::get("/amenities/reservations", [AmenityReservationController::class, "index"]);
    Route::post("/amenity/reservation", [AmenityReservationController::class, "store"]);
    Route::get("/amenity/reservation/{AmenityReservation}", [AmenityReservationController::class, "show"]);
    Route::put("/amenity/reservation/{AmenityReservation}", [AmenityReservationController::class, "update"]);
    Route::delete("/amenity/reservation/{AmenityReservation}", [AmenityReservationController::class, "destroy"]);
});
