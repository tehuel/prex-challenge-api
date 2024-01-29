<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasFormattedJsonResponse;
use App\Services\Giphy\GiphyService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    use HasFormattedJsonResponse;

    public function __construct(private readonly GiphyService $giphyService) {}

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'query' => ['required'],
            'limit' => ['nullable'],
            'offset' => ['nullable'],
        ]);

        $params = Arr::whereNotNull([
            'query' => $request->get('query'),
            'limit' => $request->get('limit'),
            'offset' => $request->get('offset'),
        ]);

        $searchData = $this->giphyService->search(...$params);

        return $this->formattedResponse($searchData);
    }
}
