<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\{JsonResponse,Response};
use Illuminate\Support\Facades\{DB,Log};

class ApiResponseClass
{
    /**
     * @param $e
     * @param $message
     * @return void
     */
    public static function rollback($e,
                                    $message = 'Something went wrong! Process not completed',
                                    $request = null): JsonResponse|Response
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    /**
     * @param $e
     * @param $message
     * @return void
     */
    public static function throw($e, $message = 'Something went wrong! Process not completed'): void
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(['message' => $message], 500));
    }

    /**
     * @param $result
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public static function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'data' => $result,
            'success' => true,
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
