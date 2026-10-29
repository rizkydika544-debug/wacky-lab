<?php

namespace Tests\Feature;

use Tests\TestCase;

class JourneyTest extends TestCase
{
    /**
     * Test that perjalanan-12-tahap route returns a 200 OK response.
     */
    public function test_journey_page_returns_successful_response(): void
    {
        $response = $this->get('/perjalanan-12-tahap');

        $response->assertStatus(200);
        $response->assertSee('Perjalanan 12 Tahap');
        $response->assertSee('SEBELUM LAHIR');
        $response->assertSee('DUNIA');
        $response->assertSee('QANTHARAH &amp; SURGA', false);
    }
}

