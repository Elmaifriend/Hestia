<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $residents = $user->house()->residents();

        return response()->json([
            "residents" => $residents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $residentValidator = Validator::make( $request, [
            "email" => "required|email",
        ]);

        if( $residentValidator->fails() ){
            return response()->json([
                "message" => "El correo no es valido",
                "errors" => $residentValidator->errors()
            ]);
        }


        $residentData = $residentValidator->validated();
        $user = User::where("email", "=", $residentData["email"])->get();
        $residentData["house_id"] = request()->user()->house()->id;
        $residentData["user_id"] = $user->id;
        $residentData["ownership"] = "Propietario";
        $residentData["status"] = "Activo";

        Resident::create($residentData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        return response()->json([
            "resident" => $resident
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resident $resident)
    {
        $residentValidator = Validator::make($request, [
            "email" => "required|email",
        ]);

        if( $residentValidator->fails() ){
            return response()->json([
                "message" => "El correo no es valido",
                "errors" => $residentValidator->errors()
            ]);
        }


        $residentData = $residentValidator->validated();
        $user = User::where("email", "=", $residentData["email"])->get();
        $residentData["house_id"] = request()->user()->house()->id;
        $residentData["user_id"] = $user->id;
        $residentData["ownership"] = "Propietario";
        $residentData["status"] = "Activo";

        $resident->update($residentData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        $user = request()->user();
        $house = $user->house();

        if( $user->id !== $resident->user_id || $user->id !== $house->owner_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        $resident->delete();
    }
}
