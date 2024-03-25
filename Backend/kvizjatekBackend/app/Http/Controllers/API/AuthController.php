<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'email' => $request->email,
            'credit' => 0,
            'isActive'  => 1
        ]);
        return response()->json([
            "message" => "User created successfully", "user" => $user
        ], 201);
    }
    public function login(LoginRequest $request){
        $user = User::where("email", $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                "message" => "Incorrect username or password"
            ], 401);
        }
        $token = $user->createToken("AuthToken")->plainTextToken;
        return response()->json([
            "token" => $token,
            "user_id" => $user->id
        ], 200);
    }
    public function logout(Request $request ){
        $user = auth()->user();
        /**@disregard */
        $user->currentAccessToken()->delete();
        $allTokens = $user->tokens;
        return response()->noContent();
        }
}
