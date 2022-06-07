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
                "message" => "internal server error"
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
                "message" => "internal server error"
            ], 400);
        }
        return response([
            "message" => "get user success",
            "user" => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function updateUser(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
