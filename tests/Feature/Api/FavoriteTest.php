<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\Giphy\GiphyService;
use Illuminate\Support\Arr;
use Mockery\MockInterface;

class FavoriteTest extends ApiTestCase
{
    const URI = '/api/favorite';

    public function test_favorite_use_gif_service(): void
    {
        $user = User::factory()->create();
        $searchQuery = $this->getFavoriteQueryParams($user);
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock
                ->shouldReceive('get')
                ->withArgs([$searchQuery['gif_id']])
                ->once()
        );

        $response = $this->json(
            method: 'GET',
            uri: $this->getUriWithParams($searchQuery),
            headers: $this->getAuthenticatedHeaders($user),
        );

        $response->assertStatus(200);
        $this->assertEquals(1, $user->favorites()->count());
    }

    public function test_favorite_add_to_favorites(): void
    {
        $user = User::factory()->create();
        $searchQuery = $this->getFavoriteQueryParams($user);
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
        $mock
            ->shouldReceive('get')
            ->withArgs([$searchQuery['gif_id']])
            ->once()
        );

        $response = $this->json(
            method: 'GET',
            uri: $this->getUriWithParams($searchQuery),
            headers: $this->getAuthenticatedHeaders($user),
        );

        $response->assertStatus(200);
        $this->assertEquals(1, $user->favorites()->count());
    }

    public function test_favorite_parameter_validation(): void
    {
        $response = $this->json(
            method: 'GET',
            uri: $this->getUriWithParams(),
            headers: $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(422);
    }

    public function test_favorite_not_authenticated(): void
    {
        $response = $this->json(
            method: 'GET',
            uri: $this->getUriWithParams(),
        );

        $response->assertStatus(401);
    }

    public function getFavoriteQueryParams(User $user): array
    {
        return [
            'user_id' => $user->id,
            'gif_id' => fake()->regexify('[A-Za-z0-9]{8}'),
            'alias' => fake()->word(),
        ];
    }
}
