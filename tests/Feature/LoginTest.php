<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_endpoint(): void
    {
        $userCredentials = [
            'email' => fake()->safeEmail,
            'password' => fake()->password,
        ];

        User::factory()->create($userCredentials);

        $response = $this->post('/api/login', $userCredentials);

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) =>
                $json
                    ->has('token')
                    ->etc()
            );
    }
}
