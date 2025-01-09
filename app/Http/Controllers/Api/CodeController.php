<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Guest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        $codeValidator = Validator::make($request->input("code"), [
            "subject" => "required",
            "number_visitors" => "required",
            "entry_date" => "required",
            "entry_time" => "required",
            "description" => "required"
        ]);

        $guestValidator = Validator::make( $request->input("guest"), [
            "name" => "required",
            "last_name" => "required",
            "phone_number" => "required",
            "email" => "required"
        ]);

        if( $codeValidator->fails() || $guestValidator->fails() ){
            return response()->json([
                "message" => "The data is incomplete",
                "errores" => [ $codeValidator->errors(), $guestValidator->errors()]
            ]);
        }

        $user = $request->user();

        $codeData = $codeValidator->validated();
        $codeData["status"] = "Pending";
        $codeData["user_id"] = $user->id;
        $codeData["code"] = Str::uuid();
        $codeData["entry"] = Carbon::createFromFormat('Y-m-d H:i', $codeData["fecha_entrada"] . ' ' . $codeData["hora_entrada"]);
        $code = code::create($codeData);

        $guestData = $guestValidator->validated();
        $guestData["code_id"] = $code->id;
        $guest = Guest::create($guestData);

        $code->guests()->save($guest);

        return response()->json([
            "message" => "code generado correctamente"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, code $code){

        $user = $request->user();

        if( $user->id !== $code->user_id ){
            return response()->json([
                "message" => "You do not have access to this information"
            ]);
        }

        $guest = Guest::where("code_id", "=", $code->id )->first();

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

        $codeValidator = Validator::make($request->input("code"), [
            "subject" => "required",
            "number_visitors" => "required",
            "entry_date" => "required",
            "entry_time" => "required",
            "description" => "required"
        ]);

        $guestValidator = Validator::make( $request->input("visitante"), [
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

        $code->guest()->delete();
        $codeData = $codeValidator->validated();
        $codeData["user_id"] = $user->id;
        $codeData["code"] = Str::uuid();
        $codeData["entrada"] = Carbon::createFromFormat('Y-m-d H:i', $codeData["fecha_entrada"] . ' ' . $codeData["hora_entrada"]);
        $code->update($codeData);


        $guestData = $guestValidator->validated();
        $guestData["code_id"] = $code->id;
        $visitante = Visitante::create($guestData);


        $code->guest()->save($visitante);

        return response()->json([
            "message" => "code actualizado correctamente"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(code $code)
    {
        $code->delete();

        return response()->json([
            "message" => "code eliminado correctamente"
        ], 201);
    }


    public function escanear( Request $request ){

        $codeEscaneado = $request->input("code");

        $code = code::where("code", $codeEscaneado)->first();
        $code->aprobar();

        return response()->json([
            "message" => "code escaneado correctamente"
        ]);
    }
}
