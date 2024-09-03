<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\JWTToken;
use App\Helpers\TokenAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Summary of userLogin
     * @param \Illuminate\Http\Request $request
     *  - email: string
     * @return \App\Helper\ResponseHelper::sendSuccess|ResponseHelper::sendError
     */
    function userLogin(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email'
            ]);

            // Get the email address from the request
            $email = $request->input('email');

            // Generate a random 4-digit OTP
            $otp = rand(1000, 9999);

            // Send the OTP to the user's email address

            // Save the OTP in the user table + create or update the user record
            $user = User::updateOrCreate(
                ['email' => $email],
                ['email' => $email, 'otp' => $otp]
            );

            if (!$user) {
                return ResponseHelper::sendError('Failed to create user', null, 500);
            }

            return ResponseHelper::sendSuccess('OTP sent successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError("Failed to login user", $th->getMessage(), 500);
        }
    }

    /**
     * Summary of verifyOtp
     * @param \Illuminate\Http\Request $request
     *  - otp: int
     * @return \App\Helper\ResponseHelper::sendSuccess|ResponseHelper::sendError
     */
    function verifyOtp(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'otp' => 'required|integer',
                'email' => 'required|email'
            ]);

            // Get the email address and OTP from the request
            $email = $request->input('email');
            $otp = $request->input('otp');

            // Find the user record
            $user = User::where('email', $email)->where('otp', $otp)->first();

            if (!$user) {
                return ResponseHelper::sendError('Invalid OTP', null, 400);
            }

            // Update the user record to remove the OTP
            $user->otp = 0;
            $user->save();

            $expiryTime = 60 * 60 * 24 * 30; // seconds * minutes * hours * days
            $token = JWTToken::createToken($user->email, $user->id, $expiryTime);

            if (!$token) {
                return ResponseHelper::sendError('Token creation failed', 200);
            }

            return ResponseHelper::sendSuccess('OTP verified successfully', null, 200)->cookie('token', $token, time() + $expiryTime);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError("Failed to verify OTP", $th->getMessage(), 500);
        }
    }

    function userLogout(Request $request)
    {
        try {
            // Invalidate the token 
            $token = $request->cookie('token');
            if ($token) {
                JWTToken::invalidateToken($token);
            }
            // Clear the token from cookie
            return ResponseHelper::sendSuccess('Logout Success', 'Logout Success')->cookie('token', '', -1);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('User logout failed', 200, $th->getMessage());
        }
    }
}