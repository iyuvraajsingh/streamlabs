<?php


namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiError
{
    public static function unauthorized($message = 'Unauthorized')
    {
        return response()->json(['error' => $message], JsonResponse::HTTP_UNAUTHORIZED);
    }
    
    public static function badRequest($message = 'Bad request')
    {
        return response()->json(['error' => $message], JsonResponse::HTTP_BAD_REQUEST);
    }

    public static function invalidToken($message = 'Invalid or expired token')
    {
        return response()->json(['error' => $message], JsonResponse::HTTP_UNAUTHORIZED);
    }

    public static function notFound($message = 'Resource not found')
    {
        return response()->json(['error' => $message], JsonResponse::HTTP_NOT_FOUND);
    }

    public static function validationError($errors, $message = 'Validation error')
    {
        return response()->json(['error' => $message, 'errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function internalServerError($message = 'Internal server error')
    {
        return response()->json(['error' => $message], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
