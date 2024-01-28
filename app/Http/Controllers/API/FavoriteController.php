<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Giphy\GiphyService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __invoke(Request $request, GiphyService $service)
    {
        $validated = $request->validate([
            'gif_id' => ['required', 'string'],
            'user_id' => ['required', 'numeric'],
            'alias' => ['required', 'string'],
        ]);

        $gifData = $service->get($validated['gif_id']);

        $completeUser = User::query()->findOrFail($validated['user_id']);
        $favorite = $completeUser->favorites()->create([
            'alias' => $validated['alias'],
            'gif_id' => $validated['gif_id'],
            'data' => json_encode($gifData),
        ]);

        return response()->json([
            'status' => 'ok',
            'data' => $favorite,
        ]);
    }
}
