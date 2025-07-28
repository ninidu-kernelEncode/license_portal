<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $tokenResult = $user->createToken('api_token');

        $tokenResult->accessToken->expires_at = now()->addHours(24);
        $tokenResult->accessToken->save();

        return response()->json([
            'access_token' => $tokenResult->plainTextToken,
            'token_type'   => 'Bearer',
            'expires_at'   => $tokenResult->accessToken->expires_at->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
