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
        $uri = self::URI . '?' . Arr::query($searchQuery);
        $headers = $this->getAuthenticatedHeaders($user);
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock
                ->shouldReceive('get')
                ->withArgs([$searchQuery['gif_id']])
                ->once()
        );

        $response = $this->json('GET', $uri, [], $headers);

        $response->assertStatus(200);
        $this->assertEquals(1, $user->favorites()->count());
    }

    public function test_favorite_add_to_favorites(): void
    {
        $user = User::factory()->create();
        $searchQuery = $this->getFavoriteQueryParams($user);
        $uri = self::URI . '?' . Arr::query($searchQuery);
        $headers = $this->getAuthenticatedHeaders($user);
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
        $mock
            ->shouldReceive('get')
            ->withArgs([$searchQuery['gif_id']])
            ->once()
        );

        $response = $this->json('GET', $uri, [], $headers);

        $response->assertStatus(200);
        $this->assertEquals(1, $user->favorites()->count());
    }

    public function test_favorite_parameter_validation(): void
    {
        $uri = self::URI;
        $headers = $this->getAuthenticatedHeaders();
        $response = $this->json('GET', $uri, [], $headers);

        $response->assertStatus(422);
    }

    public function test_favorite_not_authenticated(): void
    {
        $uri = self::URI;
        $response = $this->json('GET', $uri);
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
