<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\AmenityReservationController;
use App\Http\Controllers\Api\MaintenanceController;

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
    //        but in future the end-point will be util
    Route::get("/amenities", [AmenityController::class, "index"]);
    Route::post("/amenity", [AmenityController::class, "store"]);
    Route::get("/amenity/{amenity}", [AmenityController::class, "show"]);
    Route::put("/amenity/{amenity}", [AmenityController::class, "update"]);
    Route::delete("/amenity/{amenity}", [AmenityController::class, "destroy"]);


    // --- Amenity Reservations ---
    Route::get("/amenities/reservations", [AmenityReservationController::class, "index"]);
    Route::post("/amenity/reservation", [AmenityReservationController::class, "store"]);
    Route::get("/amenity/reservation/{amenityReservation}", [AmenityReservationController::class, "show"]);
    Route::put("/amenity/reservation/{amenityReservation}", [AmenityReservationController::class, "update"]);
    Route::delete("/amenity/reservation/{amenityReservation}", [AmenityReservationController::class, "destroy"]);


    // --- Maintenance ---
    Route::get("/maintenance/requests", [MaintenanceController::class, "index"]);
    Route::post("/maintenance/request", [MaintenanceController::class, "store"]);
    Route::get("/maintenance/request/{maintenance}", [MaintenanceController::class, "show"]);
    Route::put("/maintenance/request/{maintenance}", [MaintenanceController::class, "update"]);
    Route::delete("/maintenance/request/{maintenance}", [MaintenanceController::class, "destroy"]);
});
