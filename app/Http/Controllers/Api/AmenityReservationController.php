<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Amenities;
use App\Models\AmenityReservation;


class AmenityReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $amenitiesReservations = $user->amenitiesReservations()->get();

        return response()->json([
            "amenities_reservations" => $amenitiesReservations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $amenityReservationValidator = Validator::make( $request->all(), [
            "amenity_id" => "required|integer",
            "scheduled_entry_day" => "required|date",
            "scheduled_entry_time" => "required",
            "scheduled_exit_time" => "required",
            "note" => "string"
        ]);

        if( $amenityReservationValidator->fails()){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $amenityReservationValidator->errors()
            ]);
        }

        $amenityReservationData = $amenityReservationValidator->validated();
        $amenityReservationData["user_id"] = $request->user()->id;
        $amenityReservation = AmenityReservation::create($amenityReservationData);

        return response()->json([
            "message" => "Resevado correctamente",
            "amenity_reservation" => $amenityReservation
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AmenityReservation $amenityReservation)
    {
        $user = request()->user();

        if( $amenityReservation->user_id !== $user->id ){
            return request()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        return response()->json([
            "amenity_reservation" => $amenityReservation
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AmenityReservation $amenityReservation)
    {
        $amenityReservationValidator = Validator::make( $request->all(), [
            "amenity_id" => "required|integer",
            "scheduled_entry_day" => "required|date",
            "scheduled_entry_time" => "required",
            "scheduled_exit_time" => "required",
            "note" => "string"
        ]);

        if( $amenityReservationValidator->fails()){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $amenityReservationValidator->errors()
            ]);
        }

        $amenityReservationData = $amenityReservationValidator->validated();
        $amenityReservation->update($amenityReservationData);

        return response()->json([
            "message" => "Resevado correctamente",
            "amenity_reservation" => $amenityReservation
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( AmenityReservation $amenityReservation )
    {
        $user = request()->user();

        if( $amenityReservation->user_id !== $user->id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        $amenityReservation->delete();

        return response()->json([
            "message" => "Eliminado correctamente"
        ]);
    }
}
