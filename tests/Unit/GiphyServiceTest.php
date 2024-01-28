<?php

namespace Tests\Unit;

use App\Services\Giphy\GifNotFoundException;
use App\Services\Giphy\GiphyService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GiphyServiceTest extends TestCase
{
    public function test_search_successful_request(): void
    {
        $mockData = [1,2,3];
        Http::fake([
            'api.giphy.com/v1/gifs/search*' => Http::response(['data' => $mockData]),
        ]);

        $service = new GiphyService();
        $response = $service->search('success');

        $this->assertEquals($mockData, $response);
        Http::assertSentCount(1);
    }

    public function test_get_successful_request(): void
    {
        $mockId = 'abc123';
        $mockData = [
            'id' => $mockId
        ];

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response(['data' => $mockData]),
        ]);

        $service = new GiphyService();
        $response = $service->get($mockId);

        $this->assertEquals($mockData, $response);
        Http::assertSentCount(1);
    }

    public function test_get_not_found_exception(): void
    {
        $mockId = 'abc123';
        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response(['data' => []], 404),
        ]);

        $this->assertThrows(
            fn () => (new GiphyService())->get($mockId),
            GifNotFoundException::class
        );

        Http::assertSentCount(1);
    }
}
