<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Guest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Json;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request ){
        $user = $request->user();

        $codes = Code::where("user_id", "=", $user->id )->get();

        return response()->json( $codes );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $codeData = $request->input("code") ?? [];
        $guestData = $request->input("guest") ?? [];


        $codeValidator = Validator::make($codeData, [
            "subject" => "required",
            "visitors_number" => "required",
            "entry_date" => "required",
            "entry_time" => "required",
            "description" => "required"
        ]);

        $guestValidator = Validator::make( $guestData, [
            "name" => "required",
            "last_name" => "required",
            "phone_number" => "required",
            "email" => "required"
        ]);

        if( $codeValidator->fails() || $guestValidator->fails() ){
            return response()->json([
                "message" => "The data is incomplete",
                "errores" => [
                    "code" => $codeValidator->errors(),
                    "guest" => $guestValidator->errors()
                ]
            ]);
        }

        $user = $request->user();

        $codeData = $codeValidator->validated();
        $codeData["status"] = "Pendiente";
        $codeData["user_id"] = $user->id;
        $codeData["code"] = Str::uuid();
        $codeData["scheduled"] = Carbon::createFromFormat('Y-m-d H:i', $codeData["entry_date"] . ' ' . $codeData["entry_time"]);
        $codeData["visitors_number"] = $codeData["visitors_number"];
        $code = Code::create($codeData);

        $guestData = $guestValidator->validated();
        $guestData["code_id"] = $code->id;
        $guest = Guest::create($guestData);

        $code->guests()->save($guest);

        return response()->json([
            "message" => "codigo generado correctamente",
            "code" => $code
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Code $code){

        $user = $request->user();

        if( $user->id !== $code->user_id ){
            return response()->json([
                "message" => "No tienes acceso a esta informacion"
            ], 401); //Unauthorized
        }

        $guest = Guest::where("code_id", "=", $code->id )->get();

        return response()->json([
            "code" => $code,
            "guest" => $guest
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, code $code )
    {
        $user = $request->user();

        if( $user->id !== $code->user->id ){
            return response()->json([
                "message" => "You do not have access to this information"
            ]);
        }

        $codeData = $request->input("code") ?? [];
        $guestData = $request->input("guest") ?? [];

        $codeValidator = Validator::make( $codeData, [
            "subject" => "required",
            "visitors_number" => "required",
            "entry_date" => "required",
            "entry_time" => "required",
            "description" => "required"
        ]);

        $guestValidator = Validator::make( $guestData, [
            "name" => "required",
            "last_name" => "required",
            "phone_number" => "required",
            "email" => "required"
        ]);

        if( $codeValidator->fails() || $guestValidator->fails() ){
            return response()->json([
                "message" => "Los datos estan incompletos",
                "errores" => [ $codeValidator->errors(), $guestValidator->errors()]
            ]);
        }

        $code->guests()->delete();
        $codeData = $codeValidator->validated();
        $codeData["user_id"] = $user->id;
        $codeData["code"] = Str::uuid();
        $codeData["entrada"] = Carbon::createFromFormat('Y-m-d H:i', $codeData["entry_date"] . ' ' . $codeData["entry_time"]);
        $code->update($codeData);


        $guestData = $guestValidator->validated();
        $guestData["code_id"] = $code->id;
        $guest = Guest::create($guestData);


        return response()->json([
            "message" => "code actualizado correctamente"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(code $code)
    {

        $user = request()->user();

        if( $code->user_id !== $user->id ){
            return response()->json([
                "message" => "No tienes acceso a esta informacion"
            ]);
        }

        $code->delete();

        return response()->json([
            "message" => "code eliminado correctamente"
        ], 201);
    }


    public function scanCode( Request $request ){

        $scannedCode = $request->input("code") ?? null;

        $code = code::where("code", $scannedCode)->first();

        switch( $code->status ){
            case "Pendiente":
                $code->checkEntry();
                $message = "Codigo aprobado correctamente";
                $httpStatus = 201;
                break;

            case "Aprobado":
                $code->checkExit();
                $message = "Salida registrada correctamente";
                $httpStatus = 201;
                break;

            case "Terminado":
                $message = "Este codigo ya fue utilizado";
                $httpStatus = 301;
                break;

            case "Cancelado":
                $message = "Este codigo fue cancelado";
                $httpStatus = 301;
                break;

            default:
                $message = "Codigo no valido";
                $httpStatus = 301;
                break;
        }

        return response()->json([
            "message" => $message
        ], $httpStatus);
    }
}
