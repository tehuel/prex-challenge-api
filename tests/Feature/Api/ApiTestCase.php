<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase;
    const URI = '/api';

    public function getAuthenticatedHeaders(User $user = null): array
    {
        return [
            'Authorization' => $user ? $this->getTokenForUser($user) : $this->getNewToken(),
        ];
    }

    public function getNewToken(): string
    {
        $userCredentials = $this->getUserCredentials();
        User::factory()->create($userCredentials);
        $response = $this->post('/api/login', $userCredentials);

        return $response->json('data.token');
    }

    public function getTokenForUser(User $user): string
    {
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return $response->json('data.token');
    }

    public function getUserCredentials(): array
    {
        return [
            'email' => fake()->safeEmail,
            'password' => fake()->password,
        ];
    }

    public function getUriWithParams(array $searchQuery = []): string
    {
        return $this::URI . '?' . Arr::query($searchQuery);
    }
}
