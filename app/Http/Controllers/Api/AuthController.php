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
            "phone_number" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|confirmed|min:8|string",
            "password_confirmation" => "required|min:8|string"
        ]);

        $user = User::create([
            "name" => $fields["name"],
            "last_name" => $fields["last_name"],
            "phone_number" => $fields["phone_number"],
            "email" => $fields["email"],
            "password" => Hash::make( $fields["password"] ),
            "role" => "Residente"
        ]);

        $token = $user->createToken("hestia_app")->plainTextToken;

        return response()->json([
            "message" => "Registrado correctamente",
            "user" => $user,
            "token" => $token
        ]);
    }


    public function login( Request $request ){
        $fields = $request->validate([
            "email" => "string|required",
            "password" => "string|required"
        ]);

        $user = User::where("email", "=", $fields["email"])->first();

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
