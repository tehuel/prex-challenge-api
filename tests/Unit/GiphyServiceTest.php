<?php

namespace Tests\Unit;

use App\Services\Giphy\GiphyService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GiphyServiceTest extends TestCase
{
    public function test_search_request(): void
    {
        $mockData = [1,2,3];
        Http::fake([
            'api.giphy.com/*' => Http::response(['data' => $mockData]),
        ]);

        $service = new GiphyService();
        $response = $service->search('success');

        $this->assertEquals($mockData, $response);
        Http::assertSentCount(1);
    }
}
