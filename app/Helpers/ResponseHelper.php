<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Summary of sendSuccess
     * @param mixed $message - success message
     * @param mixed $result - data to be returned in the response
     * @param mixed $statusCode - status code, default is 200
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function sendSuccess($message, $result, $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            // 'data' => $result,
            $result,
        ];
        return response()->json($response, $statusCode);
    }


    /**
     * Summary of sendError
     * @param mixed $message - error message
     * @param mixed $statusCode - error status code, default is 400
     * @param mixed $errors - error data array
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function sendError($message, $errors = [], $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $statusCode);
    }
}