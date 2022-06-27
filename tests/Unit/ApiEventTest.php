<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiEventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_getAllEvents_positive() {

        $response = $this->getJson('/api/events');
        
        $response
            ->assertStatus(200);
    }

    public function test_getAllEvents_negative() {

        $response = $this->getJson('/api/events');
        
        $response
            ->assertStatus(200);
    }

    public function test_getAllEventsTrending_positive() {

        $response = $this->getJson('/api/events/trending');
        
        $response
            ->assertStatus(200);
    }

    public function test_getAllEventsTrending_negative() {

        $response = $this->getJson('/api/events/trending');
        
        $response
            ->assertStatus(200);
    }

    public function test_getEvent_positive() {

        $response = $this->getJson('/api/events/1');
        
        $response
            ->assertStatus(200);
    }
    public function test_getEvent_negative() {

        $response = $this->getJson('/api/events/1');
        
        $response
            ->assertStatus(200);
    }
}
