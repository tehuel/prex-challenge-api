<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasFormattedJsonResponse;
use App\Services\Giphy\GiphyService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use HasFormattedJsonResponse;

    public function __construct(private readonly GiphyService $giphyService) {}

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        ['query' => $query] = $request->validate([
            'query' => ['required'],
            'limit' => ['nullable'],
            'offset' => ['nullable'],
        ]);

        $searchData = $this->giphyService->search($query);

        return $this->formattedResponse($searchData);
    }
}
