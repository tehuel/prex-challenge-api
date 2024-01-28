<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasFormattedJsonResponse;
use App\Models\User;
use App\Services\Giphy\GiphyService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use HasFormattedJsonResponse;

    public function __construct(private readonly GiphyService $giphyService) {}

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'gif_id' => ['required', 'string'],
            'user_id' => ['required', 'numeric'],
            'alias' => ['required', 'string'],
        ]);

        $gifData = $this->giphyService->get($validated['gif_id']);

        $completeUser = User::query()->findOrFail($validated['user_id']);
        $favoriteData = $completeUser->favorites()->create([
            'alias' => $validated['alias'],
            'gif_id' => $validated['gif_id'],
            'data' => json_encode($gifData),
        ]);

        return $this->formattedResponse($favoriteData);
    }
}
