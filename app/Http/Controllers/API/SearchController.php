<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Giphy\GiphySearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, GiphySearchService $service)
    {
        ['query' => $query] = $request->validate([
            'query' => ['required'],
            'limit' => ['nullable'],
            'offset' => ['nullable'],
        ]);

        $result = $service->search($query);

        return response()->json($result);
    }
}
