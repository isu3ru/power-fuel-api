<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login and return CSRF token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAndGetCsrfToken(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        Auth::attempt($credentials);

        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'csrf-token' => csrf_token(),
        ]);
    }

    /**
     * Get CSRF token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCsrfToken(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $csrfToken = $request->session()->token();

        return response()->json(['csrf-token' => $csrfToken]);
    }
}
