<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
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
