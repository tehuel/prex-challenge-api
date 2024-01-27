<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Giphy\GiphySearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Mockery\MockInterface;
use Tests\TestCase;

class SearchTest extends TestCase
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

    public function getUserToken(): string
    {
        $userCredentials = [
            'email' => fake()->safeEmail,
            'password' => fake()->password,
        ];
        User::factory()->create($userCredentials);
        $response = $this->post('/api/login', $userCredentials);

        return $response->json('token');
    }
}
