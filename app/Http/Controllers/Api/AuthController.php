<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Models\User;

class AuthController extends Controller
{
    public function register( Request $request ){
        $fields = $request->validate([
            "name" => "required|string",
            "last_name" => "required|string",
            "cell_phone" => "required|string",
            "email" => "required|string|unique:usuarios,correo",
            "password" => "required|confirmed|min:8|string",
            "password_confirmation" => "required|min:8|string"
        ]);

        $usuario = User::create([
            "name" => $fields["name"],
            "last_name" => $fields["last_name"],
            "cell_phone" => $fields["cell_phone"],
            "email" => $fields["email"],
            "password" => Hash::make( $fields["password"] ),
            "rol" => "Residente"
        ]);

        $token = $usuario->createToken("hestia_app")->plainTextToken;

        return response()->json([
            "user" => $usuario,
            "token" => $token
        ]);
    }


    public function login( Request $request ){
        $fields = $request->validate([
            "email" => "string|required",
            "password" => "string|required"
        ]);

        $user = User::where("correo", "=", $fields["correo"])->first();

        if( !$user || !Hash::check( $fields["password"], $user->password ) ){
            return response([
                "message" => "Bad Credentials"
            ], 401);
        }

        $token = $user->createToken("hestia_app")->plainTextToken;


        return response()->json([
            "message" => "Correct Loggin",
            "user" => $user,
            "token" => $token
        ], 201 );
    }


    public function logout( Request $response){
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Logged out"
        ], 201 );
    }
}
