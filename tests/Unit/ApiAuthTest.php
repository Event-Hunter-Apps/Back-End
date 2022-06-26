<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_positive() {
        $data = [
            'nama' => "restu",
            'password' => "rahasia",
            'password_confirmation' => "rahasia",
            'email' => "restu@gmail.com",
            "no_hp" => "081312311617",
            "role_id" => 1
        ];

        $response = $this->postJson('/api/register', $data);
 
        $response
            ->assertStatus(200);
    }

    public function test_register_negative() {
        $data = [
            'nama' => "restu",
            'password_confirmation' => "rahasia",
            'email' => "restu@gmail.com",
            "no_hp" => "081312311617",
            "role_id" => 1
        ];

        $response = $this->postJson('/api/register', $data);
 
        $response
            ->assertStatus(422);
    }
}
