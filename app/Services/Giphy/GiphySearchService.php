<?php

namespace App\Services\Giphy;

use Illuminate\Support\Facades\Http;

class GiphySearchService
{
    public function search(string $query, int $limit = 10, int $offset = 0): array
    {
        $response = Http::get('api.giphy.com/v1/gifs/search', [
            'api_key' => config('giphy.key'),
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ]);
        return $response->json()['data'];
    }

    public function get(string $id)
    {
        $response = Http::get('api.giphy.com/v1/gifs/' . $id, [
            'api_key' => config('giphy.key'),
        ]);
        return $response->json()['data'];
    }
}
