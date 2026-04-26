<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success(string $message, mixed $data = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error(string $message, mixed $errors = null, int $code = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $errors,
        ], $code);
    }
}
