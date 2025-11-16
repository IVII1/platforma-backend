<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || Hash::check($request->password, $user->password)) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['message' => 'The credntials you have entered are incorrect. Please try again.']);
            }
        }
        $tokenName = 'Login token';
        $abilities = ['*'];
        $expiresAt = now()->addMonth();
        $token = $user->createToken($tokenName, $abilities, $expiresAt);
        $token = $token->plainTextToken;

        return response()->json(['message' => "Success", 'token' => $token, 'user' => $user['name'], 'expiresAt' => $expiresAt], 200);
    }
}
