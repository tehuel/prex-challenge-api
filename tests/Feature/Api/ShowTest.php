<?php

namespace Tests\Feature\Api;

use App\Services\Giphy\GiphyService;
use Mockery\MockInterface;

class ShowTest extends ApiTestCase
{
    const URI = '/api/gif';

    public function test_get_gif_result()
    {
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock->shouldReceive('get')
                ->withArgs([
                    'abc123',
                ])
                ->andReturn([])
                ->once()
        );

        $id = 'abc123';
        $uri = self::URI . '/' . $id;
        $headers = $this->getAuthenticatedHeaders();
        $response = $this->json('GET', $uri, [], $headers);
        $response->assertStatus(200);
    }

    public function test_get_empty_id()
    {
        $uri = self::URI . '/ ';
        $headers = $this->getAuthenticatedHeaders();
        $response = $this->json('GET', $uri, [], $headers);
        $response->assertStatus(422);
    }

    public function test_get_no_id()
    {
        $uri = self::URI . '/';
        $headers = $this->getAuthenticatedHeaders();
        $response = $this->json('GET', $uri, [], $headers);
        $response->assertStatus(404);
    }

    public function test_get_not_authenticated(): void
    {
        $id = 'abc123';
        $uri = self::URI . '/' . $id;
        $response = $this->json('GET', $uri);
        $response->assertStatus(401);
    }
}
