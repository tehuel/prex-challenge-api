<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
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
