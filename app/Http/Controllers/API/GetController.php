<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasFormattedJsonResponse;
use App\Services\Giphy\GiphyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetController extends Controller
{
    use HasFormattedJsonResponse;

    public function __construct(private readonly GiphyService $giphyService) {}

    public function __invoke(Request $request, string $gif)
    {
        $validator =Validator::make([
            'gif' => $gif,
        ], [
            'gif' => ['required'],
        ]);
        $validator->validate();

        $gifData = $this->giphyService->get($gif);

        return $this->formattedResponse($gifData);
    }
}
