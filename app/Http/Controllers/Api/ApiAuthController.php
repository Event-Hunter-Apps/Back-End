<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request) {
        $validator = $request->validate([
            'nama' => 'required',
            'password' => 'required|string|confirmed',
            'email' => 'required|string|email:dns|unique:users',
            'no_hp' => 'required|string|unique:users',
            'role_id' => 'required'
        ], [
            "no_hp.unique" => "Phone number already used!",
        ]);

        $request['password'] = bcrypt($request['password']);
        $user = User::create($request->all());
        $token = $user->createToken('secret_key')->plainTextToken;

        return response([
            'message' => 'register success',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response([
            "message"=> "log out success"
        ], 200);
    }

    public function login(Request $request) {
        $validator = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request['email'])->first();
        if(!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                "message" => "invalid username or password",
            ], 400);
        }
        
        $token = $user->createToken('secret_key')->plainTextToken;
        $response = [
            "message" => "login success",
            'token' => $token,
        ];

        return response($response, 200);
    }
}
