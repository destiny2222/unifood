<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;


class B2BRegisterController extends Controller
{
    /**
     * Register a new standard user account.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                if ($existingUser->kyc()->exists()) {
                    DB::rollBack();
                    return response()->json([
                        'errors' => ['email' => ['This email is already associated with a B2B account. Please log in.']]
                    ], 422);
                }

                if (Hash::check($request->password, $existingUser->password)) {
                    $token = $existingUser->createToken('b2b_token')->plainTextToken;
                    DB::commit();
                    return response()->json([
                        'message' => 'Account linked successfully. Please complete your B2B profile.',
                        'token' => $token,
                        'token_type' => 'Bearer',
                        'data' => $existingUser,
                    ], 200);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'errors' => ['password' => ['This email belongs to an existing personal account. Please enter your correct password to link it, or log in first.']]
                    ], 422);
                }
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('b2b_token')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'Registration successful.',
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error registration: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while registering.',
            ], 500);
        }
    }

   
}
