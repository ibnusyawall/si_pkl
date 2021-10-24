<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponseJson($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => !empty($result) ? $result : [],
        ];

        return response()->json($response, 200);
    }

    public function sendErrorJson($error, $msgError = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'data' => !empty($msgError) ? $msgError : [],
        ];

        return response()->json($response, $code);
    }

    public function check() {
        $response = [
            'success' => true,
            'message' => 'authorized',
        ];

        return response()->json($response, 200);
    }
}
