<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Classes\ApiResponseClass;

abstract class Controller extends BaseController
{
    protected function respond($result, string $message, int $code = 200)
    {
        return ApiResponseClass::sendResponse($result, $message, $code);
    }

    protected function respondCreated($result, string $message = 'Created successfully.')
    {
        return ApiResponseClass::sendCreated($result, $message);
    }

    protected function respondDeleted(string $message = 'Deleted successfully.')
    {
        return ApiResponseClass::sendDeleted($message);
    }

    protected function respondError(string $message, int $code = 400, array $errors = [])
    {
        return ApiResponseClass::sendError($message, $code, $errors);
    }

    protected function respondValidationError(array $errors)
    {
        return ApiResponseClass::sendValidationError($errors);
    }
}
