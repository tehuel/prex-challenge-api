<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->all(['email', 'password']);
        $auth = Auth::attempt($credentials);

        if (!$auth) {
            return response()->json([], 401);
        }

        $token = Auth::user()->createToken('api-token');
        return response()->json([
            'status' => 'ok',
            'token' => $token->plainTextToken,
        ]);
    }
}
