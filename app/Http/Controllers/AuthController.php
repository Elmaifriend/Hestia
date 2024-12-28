<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Models\Usuario;

class AuthController extends Controller
{
    public function register( Request $request ){
        $args = $request->validate([
            "nombre" => "required|string",
            "apellido" => "required|string",
            "telefono" => "required|string",
            "correo" => "required|string|unique:usuarios,correo",
            "contrasena" => "required|string"
        ]);

        $usuario = Usuario::create([
            "nombre" => $args["nombre"],
            "apellido" => $args["apellido"],
            "telefono" => $args["telefono"],
            "correo" => $args["correo"],
            "contrasena" => Hash::make( $args["contrasena"] ),
            "rol" => "Residente"
        ]);

        $token = $usuario->createToken("hestia-app")->plainTextToken;

        $response = [
            "user" => $usuario,
            "token" => $token
        ];

        return response($response, 201);
    }


    public function login( Request $request ){
        $campos = $request->validate([
            "correo" => "string|required",
            "contrasena" => "string|required"
        ]);

        $usuario = Usuario::where("correo", "=", $campos["correo"])->first();

        if( !$usuario || !Hash::check($campos["contrasena"], $usuario->contrasena ) ){
            return response([
                "message" => "Bad Credentials"
            ], 401);
        }

        $token = $usuario->createToken("hestia-app")->plainTextToken;

        $response = [
            "usuario" => $usuario,
            "token" => $token
        ];

        return response($response, 201);
    }


    public function logout( Request $response){
        auth()->user()->tokens()->delete();

        $response = [
            "message" => "Logged out"
        ];

        return response( $response, 201 );
    }
}
