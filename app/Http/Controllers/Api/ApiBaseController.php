<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ApiBaseController extends Controller
{
    public function jsonResponse(int $statusCode, $response = [], string $message = null): JsonResponse
    {
        return response()->json(['status_code' => $statusCode, 'message' => $message, 'data' => $response], $statusCode);
    }
}
