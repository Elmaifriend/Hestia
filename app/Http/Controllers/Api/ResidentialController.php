<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Residential;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ResidentialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "string|min:4|required",
            "address" => "string|min:10|required"
        ]);

        if( $validator->fails() ){
            return response()->json([
                "messagge" => "Falta informacion",
                "errors" => $validator->errors()
            ], 400);
        }


        $user = $request->user();

        $fields = $validator->validated();
        $fields["manager_id"] = $user->id;

        $residential = Residential::create($fields);

        return response()->json([
            "message" => "Creado correctamente",
            "residential" => $residential
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Residential $residential)
    {
        if( request()->user()->id != $residential->manager_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        return response()->json([
            "residential" => $residential
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "string|min:4|required",
            "address" => "string|min:10|required"
        ]);

        if( $validator->fails() ){
            return response()->json([
                "message" => "Falta informacion",
                "errors" => $validator->errors()
            ], 400);
        }

        $residential = Residential::find($id);
        $user = $request->user();
        
        if( $user->id != $residential->manager_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ]);
        }

        $fields = $validator->validated();
        $fields["manager_id"] = $user->id;

        $residential->update($fields);
        $residential->save();

        return response()->json([
            "message" => "Actualizado correctamente",
            "residential" => $residential
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Residential $residential)
    {
        if( request()->user()->id !== $residential->manager_id ){
            return response()->json([
                "message" => "No tienes acceso a estos datos"
            ], 401);
        }

        $residential->delete();
        return response()->json([
            "message" => "Eliminado correctamente"
        ]); 
    }
}
