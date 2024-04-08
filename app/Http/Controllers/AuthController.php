<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register(Request $request): JsonResponse
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);



        $userExists = User::where('email', $request->email)->exists();
        if ($userExists) {
            return response()->json(['error' => 'The provided email already exists.'], 409);
        }


        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }


    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Authentication successful'], 200);
        } else {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 403);
        }
    }


    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logout success.'], 200);
    }


    public function refreshToken(): JsonResponse
    {
        $user = auth()->user();
        $token = $user->createToken('Token Name')->plainTextToken;

        return response()->json(['access_token' => $token]);
    }



    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'token' => 'required|string',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully.'], 200);
        } else {
            return response()->json(['error' => 'Invalid token or email.'], 400);
        }
    }



    public function deleteUser(): JsonResponse
    {
        $user = auth()->user();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);
    }


}









