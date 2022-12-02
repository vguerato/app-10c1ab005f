<?php

namespace App\Compounds;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function responseError(int $code, string $message, array $details = []): JsonResponse
    {
        return $this->response($code, [
            'code' => $code,
            'message' => $message,
            ...$details,
        ]);
    }

    public function responseSuccess(int $code, string $message, $data = null): JsonResponse
    {
        return $this->response($code, [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function response(int $status, array $content): JsonResponse
    {
        return response()->json($content, $status);
    }
}
