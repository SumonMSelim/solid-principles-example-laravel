<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_health_endpoint_is_accessible(): void
    {
        $response = $this->get('/up');

        $response->assertOk();
    }
}
