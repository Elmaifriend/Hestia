<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $maintenanceRequestList = $user->maintenanceRequests()->get();

        return response()->json([
            "maintenance_requests" => $maintenanceRequestList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maintenanceRequestValidator = Validator::make($request->all(),[
            "title" => "string|required|min:8",
            "description" => "string|required|min:20"
        ]);

        if( $maintenanceRequestValidator->fails() ){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $maintenanceRequestValidator->errors()
            ]);
        }

        $user = request()->user();
        $maintenanceRequestData = $maintenanceRequestValidator->validated();
        $maintenanceRequestData["user_id"] = $user->id;
        $maintenanceRequestData["status"] = "En Revision";
        $maintenanceRequestData["evidence"] = null;

        $maintenanceRequest = Maintenance::create($maintenanceRequestData);

        return response()->json([
            "message" => "Solicitud creada correctamente",
            "maintenance_request" => $maintenanceRequest
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        $user = request()->user();

        if( $user->id !== $maintenance->user_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ], 401);
        }

        return response()->json([
            "maintenance_request" => $maintenance
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $maintenanceRequestValidator = Validator::make($request->all(),[
            "title" => "string|required|min:8",
            "description" => "string|required|min:20"
        ]);

        if( $maintenanceRequestValidator->fails() ){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $maintenanceRequestValidator->errors()
            ]);
        }

        $user = request()->user();
        $maintenanceRequestData = $maintenanceRequestValidator->validated();
        $maintenanceRequestData["user_id"] = $user->id;
        $maintenanceRequestData["status"] = "En Revision";
        $maintenanceRequestData["evidence"] = null;

        $maintenance->update($maintenanceRequestData);

        return response()->json([
            "message" => "Solicitud actualizada correctamente",
            "maintenance_request" => $maintenance
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $user = request()->user();

        if( $user->id !== $maintenance->user_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        $maintenance->delete();

        return response()->json([
            "message" => "Eliminado correctamente"
        ]);
    }
}
