<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\HasFormattedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HasFormattedJsonResponse;

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

        $token = Auth::user()->createToken('api-token', ['*'], now()->addMinutes(30));

        return $this->formattedResponse($token->plainTextToken);
    }
}
