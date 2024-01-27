<?php

namespace Tests\Unit;

use App\Services\Giphy\GiphySearchService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GiphySearchServiceTest extends TestCase
{
    public function test_search_request(): void
    {
        $mockData = [1,2,3];
        Http::fake([
            'api.giphy.com/*' => Http::response(['data' => $mockData]),
        ]);

        $service = new GiphySearchService();
        $response = $service->search('success');

        $this->assertEquals($mockData, $response);
        Http::assertSentCount(1);
    }
}
