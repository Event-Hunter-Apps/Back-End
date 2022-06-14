<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class ApiUserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::whereIn('role_id', [2,3])->get();
        if (!$users) {
            return response([
                "message" => "bad request"
            ], 400);
        }
        return response([
            "message" => "get all users success",
            "user" => $users
        ], 200);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response([
                "message" => "bad request"
            ], 400);
        }
        return response([
            "message" => "get user success",
            "user" => $user
        ], 200);
    }

    public function getUserByToken()
    {
        $user = User::find(auth()->user()->id);
        if (!$user) {
            return response([
                "message" => "bad request"
            ], 400);
        }
        return response([
            "message" => "get user success",
            "user" => $user
        ], 200);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response([
                "message" => "bad request"
            ], 400);
        }
        $validator = $request->validate([
            'nama' => 'required',
            'no_hp' => 'required|string|unique:users,no_hp,'.$user->id.'id',
        ], [
            "no_hp.unique" => "Phone number already used!"
        ]);
        
        $user->update($request->all());
        return response([
            "message" => "get user success",
            "user" => $user
        ], 200);
    }
}
