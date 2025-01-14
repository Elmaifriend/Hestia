<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = request()->user()->houses();

        return response()->json([
            "houses" => $houses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->all();

        $houseValidator = Validator::make( $fields, [
            "residential_id" => "required|integer",
            "house_number" => "required|string",
            "status" => "Habitada"
        ]);

        if( $houseValidator->fails() ){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $houseValidator->errors()
            ]);
        }

        $user = request()->user();

        $houseData = $houseValidator->validated();
        $houseData["owner_id"] = $user->id;


        $house = House::create($houseData);

        return response()->json([
            "message" => "Casa creada correctamente"
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        $user = request()->user();

        $residents = $house->residents();

        //Adding all residents in array to check if the user have access
        foreach( $residents as $resident ){
            $residentsList[] = $resident->id;
        }

        if( !in_array( $user->id, $residentsList ) || $house->owner_id !== $user->id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ], 401);
        }

        return response()->json([
            "house" => $house
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        $fields = $request->all();

        $houseValidator = Validator::make( $fields, [
            "residential_id" => "required|integer",
            "owner_id" => "required",
            "house_number" => "required|string",
            "status" => "required|string"
        ]);

        if( $houseValidator->fails() ){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $houseValidator->errors()
            ]);
        }

        $houseData = $houseValidator->validated();
        $house->update($houseData);

        return response()->json([
            "message" => "Casa creada correctamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $user = request()->user();

        if( $user->id !== $house->owner_id ){
            return response()->json([
                "message" => "No tienes acceso a esta informacion"
            ], 401);
        }

        return response()->json([
            "message" => "Eliminado correctamente"
        ]);
    }
}
