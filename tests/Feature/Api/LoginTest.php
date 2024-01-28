<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class LoginTest extends ApiTestCase
{
    public function test_login_endpoint_success(): void
    {
        $userCredentials = $this->getUserCredentials();

        User::factory()->create($userCredentials);

        $response = $this->post('/api/login', $userCredentials);

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) =>
                $json->has('token')->etc()
            );
    }

    public function test_login_endpoint_user_not_found(): void
    {
        $userCredentials = $this->getUserCredentials();

        $response = $this->post('/api/login', $userCredentials);

        $response->assertStatus(401);
    }

    public function test_login_endpoint_missing_parameters(): void
    {
        $response = $this->post('/api/login');

        $response->assertStatus(302);
    }
}
