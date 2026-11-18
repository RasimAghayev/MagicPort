<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_health_live_returns_ok(): void
    {
        $response = $this->get('/health/live');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'live']);
    }

    public function test_health_ready_returns_ok(): void
    {
        $response = $this->get('/health/ready');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'ready']);
    }

    public function test_welcome_page_returns_ok(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
