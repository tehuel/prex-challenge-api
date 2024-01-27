<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Giphy\GiphySearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $gif, GiphySearchService $service)
    {
        $validator =Validator::make([
            'gif' => $gif,
        ], [
            'gif' => ['required'],
        ]);
        $validator->validate();

        return $service->get($gif);
    }
}
