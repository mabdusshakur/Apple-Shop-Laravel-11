<?php
namespace App\Helpers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;



class JWTToken
{

    /**
     * Creates a JWT token with the given user email and user ID.
     *
     * @param string $userEmail The email of the user.
     * @param int $userId The DB ID of the user.
     * @param int $expiryTime The expiry time of the token in seconds. Default is 3600 seconds.
     * @return string The generated JWT token.
     */

    public static function createToken($userEmail, $userId, $expiryTime = 3600): string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => config('app.name'),
            'iat' => time(),
            'exp' => time() + $expiryTime,
            'email' => $userEmail,
            'id' => $userId,
            'is_admin' => self::isAdmin($userId)
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * Checks if the user is an admin.
     *
     * @param string $user The email of the user.
     * @return bool Returns true if the user is an admin, otherwise returns false.
     */
    private static function isAdmin($user)
    {
        return User::where('id', $user)->first()->is_admin;
    }

    /**
     * Decode a JWT token.
     *
     * @param string|null $token The encoded JWT token to decode.
     * @return mixed Returns the decoded object if successful, otherwise returns 'unauthorized'.
     */
    public static function decodeToken($token)
    {
        try {
            if ($token == null) {
                return 'Unauthorized';
            }
            $key = env('JWT_KEY');

            if (self::isTokenInvalid($token)) {
                return 'Unauthorized';
            }

            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Throwable $th) {
            return 'Unauthorized';
        }
    }

    /**
     * Invalidates a token by storing it in the cache.
     *
     * @param string $token The token to invalidate.
     */
    public static function invalidateToken($token)
    {
        Cache::put($token, true, now()->addMonth());
    }

    /**
     * Checks if a token is invalid.
     *
     * @param string $token The token to check.
     * @return bool Returns true if the token is invalid, otherwise returns false.
     */
    public static function isTokenInvalid($token)
    {
        return Cache::has($token);
    }
}