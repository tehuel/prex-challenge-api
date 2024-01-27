<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\Giphy\GiphySearchService;
use Illuminate\Support\Arr;
use Mockery\MockInterface;

class SearchTest extends ApiTestCase
{
    public function test_search_results(): void
    {
        $searchQuery = [
            'query' => 'success',
        ];
        $this->mock(GiphySearchService::class, fn(MockInterface $mock) =>
            $mock->shouldReceive('search')
                ->withArgs([
                    'success',
                ])
                ->andReturn([])
        );

        $uri = '/api/search?' . Arr::query($searchQuery);
        $headers = [
            'Authorization' => $this->getUserToken(),
        ];

        $response = $this->json('GET', $uri, [], $headers);
        $response->assertStatus(200);
    }

    public function test_search_parameter_validation(): void
    {
        $uri = url('/api/search', []);
        $headers = [
            'Authorization' => $this->getUserToken(),
        ];
        $response = $this->json('GET', $uri, [], $headers);

        $response->assertStatus(422);
    }

    public function test_search_not_authenticated(): void
    {
        $response = $this->json('GET', '/api/search');
        $response->assertStatus(401);
    }
}
