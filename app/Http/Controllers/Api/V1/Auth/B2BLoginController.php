<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class B2BLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'errors' => ['email' => ['These credentials do not match our records.']]
                ], 422);
            }

            // Generate Sanctum token
            $token = $user->createToken('b2b_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful.',
                'token' => $token,
                // 'token_type' => 'Bearer',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error login: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while logging in.',
            ], 500);
        }
    }

     /**
     * Get the authenticated user's profile and KYC review status.
     */
    public function me(Request $request)
    {
        try {
            $user = $request->user();

            return response()->json([
                'user' => $user->load('kyc'),
                'b2b_status' => $user->kyc ? $user->kyc->status : 'none',
                'current_view' => $user->current_view ?? 'personal',
            ]);
        } catch (\Exception $e) {
            Log::error("Error getting user profile: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while getting user profile.',
            ], 500);
        }
    }
}
