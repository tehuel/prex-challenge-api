<?php

namespace Tests\Feature\Api;

use App\Services\Giphy\GiphyService;
use Mockery\MockInterface;

class ShowTest extends ApiTestCase
{
    const URI = '/api/gif';

    public function test_get_gif_result()
    {
        $gifId = 'abc123';
        $this->mock(GiphyService::class, fn(MockInterface $mock) =>
            $mock->shouldReceive('get')
                ->withArgs([
                    $gifId,
                ])
                ->andReturn([])
                ->once()
        );

        $uriWithGifId = $this::URI . '/' . $gifId;
        $response = $this->json(
            method: 'GET',
            uri: $uriWithGifId,
            headers: $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(200);
    }

    public function test_get_empty_id()
    {
        $uriWithEmptyGifId = $this::URI . '/ /';
        $response = $this->json(
            method: 'GET',
            uri: $uriWithEmptyGifId,
            headers: $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(422);
    }

    public function test_get_no_id()
    {
        $uriWithNoGifId = $this::URI;
        $response = $this->json(
            method: 'GET',
            uri: $uriWithNoGifId,
            headers: $this->getAuthenticatedHeaders(),
        );

        $response->assertStatus(404);
    }

    public function test_get_not_authenticated(): void
    {
        $uriWithGifId = $this::URI . '/abc1234/';

        $response = $this->json(
            method: 'GET',
            uri: $uriWithGifId,
        );

        $response->assertStatus(401);
    }
}
