<?php

namespace App\Classes;

use Illuminate\Http\JsonResponse;

class ApiResponseClass
{
    public static function sendResponse($result, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $result,
        ], $code);
    }

    public static function sendError(string $message, int $code = 400, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public static function sendCreated($result, string $message = 'Created successfully.'): JsonResponse
    {
        return self::sendResponse($result, $message, 201);
    }

    public static function sendDeleted(string $message = 'Deleted successfully.'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => null,
        ], 204);
    }

    public static function sendValidationError(array $errors): JsonResponse
    {
        return self::sendError('Validation failed.', 422, $errors);
    }
}
