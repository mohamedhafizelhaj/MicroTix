<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request) {

        try {
            $hashedPassword = Hash::make($request->password);

            $user = User::create([
                ...$request->only(['fullname', 'email', 'role']),
                'password' => $hashedPassword
            ]);

            return new UserResource($user);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function login(LoginRequest $request) {
        
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password))
                return response()->json(['success' => false, 'error' => 'Email or password is incorrect']);

            $token = $user->createToken('access_token')->plainTextToken;
            return (new UserResource($user))->additional(['token' => $token]);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }
}
