<?php

namespace Tests\Feature\Api;

use App\Services\Giphy\GiphyService;
use Illuminate\Support\Arr;
use Mockery\MockInterface;

class SearchTest extends ApiTestCase
{
    const URI = '/api/search';

    public function test_search_results(): void
    {
        $searchQuery = [
            'query' => 'success',
        ];

        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock->shouldReceive('search')
                ->withArgs([
                    'success',
                ])
                ->andReturn([])
                ->once()
        );

        $response = $this->json(
            'GET',
            $this->getUriWithParams($searchQuery),
            [],
            $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(200);
    }

    public function test_search_validate_limit(): void
    {
        $searchQuery = [
            'query' => 'success',
            'limit' => '0',
        ];

        $response = $this->json(
            'GET',
            $this->getUriWithParams($searchQuery),
            [],
            $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(422);
    }

    public function test_search_use_limit_offset_params(): void
    {
        $searchQuery = [
            'query' => 'success',
            'limit' => 5,
            'offset' => 15,
        ];

        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock->shouldReceive('search')
                ->withArgs([
                    'success',
                    5,
                    15.
                ])
                ->andReturn([])
                ->once()
        );

        $response = $this->json(
            'GET',
            $this->getUriWithParams($searchQuery),
            [],
            $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(200);
    }

    public function test_search_required_parameter_validation(): void
    {
        $response = $this->json(
            'GET',
            $this->getUriWithParams(),
            [],
            $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(422);
    }

    public function test_search_not_authenticated(): void
    {
        $response = $this->json(
            'GET',
            self::URI
        );

        $response->assertStatus(401);
    }
}
