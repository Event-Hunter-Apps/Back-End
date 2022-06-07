<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request) {
        $validator = $request->validate([
            'nama' => 'required',
            'password' => 'required|string|confirmed',
            'email' => 'required|string|email:dns|unique:users',
            'no_hp' => 'required|string|unique:users'
        ], [
            "unique" => "Email already used!",
            "required" => "Please fill in all fields!",
            "confirmed" => "Password doesn't match!"
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'nama' => $validator['nama'],
            'email' =>  $validator['email'],
            'password' => bcrypt($validator['password']),
            'role_id' => 1,
            'no_hp' => $validator['no_hp']
        ]);

        $token = $user->createToken('secret_key')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $response = ["message"=> "Logged Out"];
        return response($response, 200);
    }

    public function login(Request $request) {
        $validator = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validator['email'])->first();
        if(!$user || !Hash::check($validator['password'], $user->password)) {
            return response([
                "message" => "invalid username or password",
            ], 400);
        }
        
        $token = $user->createToken('secret_key')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }
}
