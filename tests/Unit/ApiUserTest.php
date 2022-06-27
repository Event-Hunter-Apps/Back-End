<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiUserTest extends TestCase
{
    public function test_getAllUsers_positive() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/users');
    
        $response
            ->assertStatus(200);
    }

    public function test_getAllUsers_negative() {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/users');
    
        $response
            ->assertStatus(403);
    }

    public function test_getUser_positive() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/users/1');
    
        $response
            ->assertStatus(200);
    }

    public function test_getUser_negative() {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/users/1');
    
        $response
            ->assertStatus(403);
    }

    public function test_getUserByToken_positive() {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/my-profile');
    
        $response
            ->assertStatus(200);
    }

    public function test_getUserByToken_negative() {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $loginResponse->assertStatus(200);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('/api/my-profile');
    
        $response->assertStatus(200);
    }

    public function test_updateUser_positive() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "nama" => "restu suma",
            "no_hp" => "081312839471"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/users/1', $updateTest);
    
        $response->assertStatus(200);
    }

    public function test_updateUser_negative() {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "nama" => "restu suma",
            "no_hp" => "081312839471"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/users/1', $updateTest);
    
        $response->assertStatus(403);
    }

    public function test_updateUserActive_positive() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "nama" => "restu ajah",
            "no_hp" => "081312839472"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/update-user-active', $updateTest);
    
        $response->assertStatus(200);
    }

    public function test_updateUserActive_negative() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "nama" => "",
            "no_hp" => "081312839472"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/update-user-active');
    
        $response->assertStatus(302);
    }

    public function test_updatePassword_positive() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "password" => '1234',
            "password_confirmation" => '1234'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/users/change-password', $updateTest);
    
        $response->assertStatus(200);
    }

    public function test_updatePassword_negative() {
        $data = [
            "email" => "restuarachman@gmail.com",
            "password" => "1234"
        ];
       
        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $updateTest = [
            "password" => '1234',
            "password_confirmation" => '1234'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->put('/api/users/change-password', $updateTest);
    
        $response->assertStatus(200);
    }
}
