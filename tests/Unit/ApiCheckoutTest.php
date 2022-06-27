<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiCheckoutTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */






    public function test_getAllCheckouts_positive()
    {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];

        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/checkouts');



        $response
            ->assertStatus(200);
    }



    public function test_getAllCheckouts_negative()
    {

        $response = $this->getJson('/api/checkouts');

        $response
            ->assertStatus(401);
    }


    public function test_getCheckouts_positive()
    {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];

        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/checkouts/1');



        $response
            ->assertStatus(200);
    }

    public function test_getCheckouts_negative()
    {

        $response = $this->getJson('/api/checkouts/100000');

        $response
            ->assertStatus(401);
    }

    public function test_createCheckout_positive()
    {

        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];

        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/checkouts');



        $response
            ->assertStatus(200);
    }

    public function test_createCheckout_negative()
    {

        $response = $this->getJson('/api/checkouts');

        $response
            ->assertStatus(401);
    }

    public function test_updateCheckout_positive()
    {
        $data = [
            "email" => "boltez@gmail.com",
            "password" => "1234"
        ];

        $loginResponse = $this->postJson('/api/login', $data);
        $token = $loginResponse["token"];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/checkouts/1');



        $response
            ->assertStatus(200);
    }

    public function test_updateCheckout_negative()
    {

        $response = $this->getJson('/api/checkouts/10000');

        $response
            ->assertStatus(401);
    }
}
