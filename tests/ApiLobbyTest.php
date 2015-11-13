<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiLobbyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReturnsTicket()
    {
        // $this->assertTrue(true);
        $response = $this->call('GET', '/api/lobby/join');
        $this->assertNotEmpty(json_decode($response->getContent(), true)['ticket']);
    }
}
