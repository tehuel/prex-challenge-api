<?php

namespace App\Services\Giphy;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GiphyService
{
    /**
     * @throws RequestException
     */
    public function search(string $query, int $limit = 10, int $offset = 0): array
    {
        $response = Http::get('api.giphy.com/v1/gifs/search', [
            'api_key' => config('giphy.key'),
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ])->throw();
        return $response->json()['data'];
    }

    /**
     * @throws GifNotFoundException
     * @throws RequestException
     */
    public function get(string $id)
    {
        try {
            $response = Http::get('api.giphy.com/v1/gifs/' . $id, [
                'api_key' => config('giphy.key'),
            ])->throw();
        } catch (RequestException $e) {
            if ($e->response->notFound()) {
                throw new GifNotFoundException();
            }
            throw $e;
        }

        return $response->json()['data'];
    }
}
