<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Codigo;
use App\Models\Visitante;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CodigoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request ){
        $usuario = $request->user();

        $codigos = Codigo::where("usuario_id", "=", $usuario->id )->get();

        return response()->json( $codigos );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $codigoValidator = Validator::make($request->input("codigo"), [
            "asunto" => "required",
            "numero_visitantes" => "required",
            "fecha_entrada" => "required",
            "hora_entrada" => "required",
            "descripcion" => "required"
        ]);

        $visitanteValidator = Validator::make( $request->input("visitante"), [
            "nombre" => "required",
            "apellido" => "required",
            "telefono" => "required",
            "correo" => "required"
        ]);

        if( $codigoValidator->fails() || $visitanteValidator->fails() ){
            return response()->json([
                "mensaje" => "Los datos estan incompletos",
                "errores" => [ $codigoValidator->errors(), $visitanteValidator->errors()]
            ]);
        }

        $usuario = $request->user();

        $codigoData = $codigoValidator->validated();
        $codigoData["status"] = "Pendiente";
        $codigoData["usuario_id"] = $usuario->id;
        $codigoData["codigo"] = Str::uuid();
        $codigoData["entrada"] = Carbon::createFromFormat('Y-m-d H:i', $codigoData["fecha_entrada"] . ' ' . $codigoData["hora_entrada"]);
        $codigo = Codigo::create($codigoData);

        $visitanteData = $visitanteValidator->validated();
        $visitanteData["codigo_id"] = $codigo->id;
        $visitante = Visitante::create($visitanteData);

        $codigo->visitantes()->save($visitante);

        return response()->json($codigo);

        return response()->json([
            "mensaje" => "Codigo generado correctamente"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Codigo $codigo){

        $usuario = $request->user();

        if( $usuario->id !== $codigo->usuario_id ){
            return response()->json([
                "mensaje" => "No tienes acceso a esta informacion"
            ]);
        }

        $visitantes = Visitante::where("codigo_id", "=", $codigo->id )->first();

        return response()->json([
            "codigo" => $codigo,
            "visitantes" => $visitantes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Codigo $codigo )
    {
        $usuario = $request->user();

        if( $usuario->id !== $codigo->usuario->id ){
            return response()->json([
                "mensaje" => "No tienes acceso a esta informacion"
            ]);
        }

        $codigoValidator = Validator::make($request->input("codigo"), [
            "asunto" => "required",
            "numero_visitantes" => "required",
            "fecha_entrada" => "required",
            "hora_entrada" => "required",
            "descripcion" => "required"
        ]);

        $visitanteValidator = Validator::make( $request->input("visitante"), [
            "nombre" => "required",
            "apellido" => "required",
            "telefono" => "required",
            "correo" => "required"
        ]);

        if( $codigoValidator->fails() || $visitanteValidator->fails() ){
            return response()->json([
                "mensaje" => "Los datos estan incompletos",
                "errores" => [ $codigoValidator->errors(), $visitanteValidator->errors()]
            ]);
        }

        $codigo->visitantes()->delete();
        $codigoData = $codigoValidator->validated();
        $codigoData["usuario_id"] = $usuario->id;
        $codigoData["codigo"] = Str::uuid();
        $codigoData["entrada"] = Carbon::createFromFormat('Y-m-d H:i', $codigoData["fecha_entrada"] . ' ' . $codigoData["hora_entrada"]);
        $codigo->update($codigoData);


        $visitanteData = $visitanteValidator->validated();
        $visitanteData["codigo_id"] = $codigo->id;
        $visitante = Visitante::create($visitanteData);


        $codigo->visitantes()->save($visitante);

        return response()->json([
            "mensaje" => "Codigo actualizado correctamente"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Codigo $codigo)
    {
        $codigo->delete();

        return response()->json([
            "mensaje" => "Codigo eliminado correctamente"
        ], 201);
    }


    public function escanear( Request $request ){

        $codigoEscaneado = $request->input("codigo");

        $codigo = Codigo::where("codigo", $codigoEscaneado)->first();
        $codigo->aprobar();

        return response()->json([
            "mensaje" => "Codigo escaneado correctamente"
        ]);
    }
}
