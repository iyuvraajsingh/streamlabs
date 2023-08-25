<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Http\Responses\ApiError;


class AuthController extends Controller
{
    /**
     * Authenticate a user using Google's OAuth token and return a JWT token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // Extract the token from the Authorization header
        $bearerToken = $request->header('Authorization');
        $token = $bearerToken ? explode(' ', $bearerToken)[1] : null;

        if (!$token) {
            return ApiError::unauthorized('Authorization token missing in the request header.');
        }

        // Initialize Google Client and verify the token
        $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($token);
        
        if (!$payload) {
            return ApiError::invalidToken('Google authentication failed. Invalid or expired token provided.');
        }

        // Check if the user exists in the database, if not, create them
        $user = User::firstOrCreate(['email' => $payload['email']], [
            'name' => $payload['name'],
            'email' => $payload['email'],
        ]);

        // Generate JWT token for the user
        try {
            $customClaims = ['exp' => now()->addMinutes(60)->timestamp]; 

            if (!$jwtToken = JWTAuth::claims($customClaims)->fromUser($user)) {
                return response()->json(['error' => 'Failed to process the request, please try again later.'], 500);
            }
        } catch (JWTException $e) {
            return ApiError::internalServerError('Failed to login. Please try again later.');
        }

        return response()->json(['token' => $jwtToken, 'message' => 'Authentication successful.']);
    }


    /**
     * Invalidate the user's JWT token, effectively logging them out.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Logged out successfully.']);
        } catch (JWTException $e) {
            return ApiError::internalServerError('Failed to log out. Please try again later.');
        }
    }

    
}
