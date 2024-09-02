<?php

namespace App\Helpers;

use App\Models\CustomerProfile;

class TokenAuth
{
    /**
     * Summary of getUserId
     * return user id from request header coming from TokenVerificationMiddleware
     */
    public static function getUserId($request): string
    {
        return $request->headers->get('id');
    }

    /**
     * Summary of getUserEmail
     * return user email from request header coming from TokenVerificationMiddleware
     */
    public static function getUserEmail($request): string
    {
        return $request->headers->get('email');
    }

    /**
     * Summary of isAdmin
     * return is_admin from request header coming from TokenVerificationMiddleware
     */
    public static function isAdmin($request): bool
    {
        return $request->headers->get('is_admin');
    }

    /**
     * Summary of getCustomerId
     * return customer id by searching user id from CustomerProfile model
     */
    public static function getCustomerId($request): int
    {
        $user_id = self::getUserId($request);
        $customer_id = CustomerProfile::where('user_id', $user_id)->first()->id;
        return $customer_id;
    }
}