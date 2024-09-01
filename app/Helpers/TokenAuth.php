<?php

namespace App\Helpers;

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
}