<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiTiketTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    public function test_getAllTickets_positive() {

        $response = $this->getJson('/api/events/1/tickets');
        
        $response
            ->assertStatus(200);
    }
    public function test_getAllTickets_negative() {

        $response = $this->getJson('/api/events/1000000/tickets');
        
        $response
            ->assertStatus(400);
    }

    public function test_getTicket_positive() {

        $response = $this->getJson('/api/tickets/1');
        
        $response
            ->assertStatus(200);
    }

    public function test_getTicket_negative() {

        $response = $this->getJson('/api/tickets/100000');
        
        $response
            ->assertStatus(400);
    }
}
