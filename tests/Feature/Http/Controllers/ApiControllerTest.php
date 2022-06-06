<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /**
     * @group Feature
     */
    public function test_api_documentation(): void
    {
        // Act
        $response = $this->get('/api/documentation');

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $this->assertStringContainsString('Secretlab Store API', $response->getContent());
    }
}
