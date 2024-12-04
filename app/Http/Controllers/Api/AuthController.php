<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Function: Register User
     * @param App\Requests\RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Create new user
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Check if the user was created successfully
            if ($user) {
                return ResponseHelper::success(
                    message: 'User has been registered successfully!',
                    data: $user,
                    statusCode: 201
                );
            }

            // If user creation failed
            return ResponseHelper::error(
                message: 'Unable to register User!',
                statusCode: 400
            );
        } catch (\Exception $e) {
            // Log the error with more context
            \Log::error('Unable to register User: ' . $e->getMessage() . ' - Line no: ' . $e->getLine());

            return ResponseHelper::error(
                status: 400,
                message: 'Unable to register User!'
            );
        }
    }

    /**
     * Function: Login User
     * @param App\Requests\LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            // Attempt to authenticate the user
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseHelper::error(
                    status: 401, // Unauthorized
                    message: 'Invalid credentials'
                );
            }

            // Retrieve the authenticated user
            $user = Auth::user();

            // Create an API Token for the user
            $token = $user->createToken('My API Token')->plainTextToken;

            // Prepare the response data
            $authUser = [
                'user' => $user,
                'token' => $token,
            ];

            // Return a successful response with user data and token
            return ResponseHelper::success(
                message: 'Login successfully',
                data: $authUser,
                statusCode: 200
            );
        } catch (\Exception $e) {
            // Log the error with additional context
            \Log::error('Unable to Login User with email: ' . $request->email . ' - ' . $e->getMessage() . ' - Line no: ' . $e->getLine());

            return ResponseHelper::error(
                status: 500, // Internal server error
                message: 'Unable to Login. Please check your credentials and try again.'
            );
        }
    }

    /**
     * Function: Fetch authenticated user's profile data
     * @param NA
     * @return JsonResponse
     */
    public function userProfile()
    {
        try {
            // Retrieve the authenticated user
            $user = Auth::user();

            if ($user) {
                return ResponseHelper::success(
                    message: 'User profile fetched successfully',
                    data: $user,
                    status: 200
                );
            }

            // If the user is not authenticated or found
            return ResponseHelper::error(
                status: 401, // Unauthorized
                message: 'Unable to fetch user profile due to invalid credentials'
            );
        } catch (\Exception $e) {
            // Log the error with additional context
            \Log::error('Unable to Fetch User Profile: ' . $e->getMessage() . ' - Line no: ' . $e->getLine());

            return ResponseHelper::error(
                status: 500, // Internal server error
                message: 'Unable to Fetch User Profile at the moment'
            );
        }
    }
/**
 * Function: Log the user out by deleting their access token.
 * @param NA
 * @return JSONResponse
 */
public function userLogout()
{
    try {
        // Retrieve the authenticated user
        $user = Auth::user();

        if ($user) {
            // Revoke the user's current access token
            $user->currentAccessToken()->delete();

            return ResponseHelper::success(
                message: 'User logged out successfully',
                status: 200
            );
        }

        // If the user is not authenticated
        return ResponseHelper::error(
            status: 401, // Unauthorized
            message: 'User not authenticated. Unable to log out.'
        );
    } catch (\Exception $e) {
        // Log the error with additional context (including user ID)
        \Log::error('Unable to logout user. Error: ' . $e->getMessage() . ' - Line: ' . $e->getLine());

        return ResponseHelper::error(
            status: 500, // Internal server error
            message: 'An error occurred while logging out.'
        );
    }
}
}