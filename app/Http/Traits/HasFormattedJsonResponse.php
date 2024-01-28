<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait HasFormattedJsonResponse
{
    public function formattedResponse(mixed $data, string $status = 'ok', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
        ], $statusCode);
    }
}
