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

        $uri = self::URI . '?' . Arr::query($searchQuery);
        $headers = $this->getAuthenticatedHeaders();

        $response = $this->json('GET', $uri, [], $headers);
        $response->assertStatus(200);
    }

    public function test_search_parameter_validation(): void
    {
        $uri = self::URI;
        $headers = $this->getAuthenticatedHeaders();
        $response = $this->json('GET', $uri, [], $headers);

        $response->assertStatus(422);
    }

    public function test_search_not_authenticated(): void
    {
        $uri = self::URI;
        $response = $this->json('GET', $uri);
        $response->assertStatus(401);
    }
}
