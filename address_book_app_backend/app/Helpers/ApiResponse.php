<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Standard response for a successful operation
     *
     * @param mixed $data
     * @param string $message
     * 
     * @return JsonResponse $response
     */
    public static function success($data = null, $message = 'Operation successful.'): JsonResponse
    {
        $response = [
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Standard response for a successful store operation
     *
     * @param mixed $data
     * @param string $message
     * 
     * @return JsonResponse $response
     */
    public static function created($data = null, $message = 'Created successfully.'): JsonResponse
    {
        $response = [
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, 201);
    }

    /**
     * Standard response for not found
     *
     * @param string $message
     * 
     * @return JsonResponse $response
    */
    public static function notFound($message = 'Not found.'): JsonResponse
    {
        $response = [
            'message' => $message
        ];

        return response()->json($response, 404);
    }

    /**
     * Standard response for an unprocessable entity
     *
     * @param mixed $data
     * @param mixed $errors
     * @param string $message
     * 
     * @return JsonResponse $response
     */
    public static function unprocessable($data = null, $errors = null, $message = 'Unprocessable Entity.'): JsonResponse
    {
        $response = [
            'data' => $data,
            'errors' => $errors,
            'message' => $message
        ];

        return response()->json($response, 422);
    }

    /**
     * Standard response for an unprocessable entity
     *
     * @param string $errorCode
     * @param string $message
     * @param mixed $errors
     * @param mixed $data
     * 
     * @return JsonResponse $response
     */
    public static function serverError($errorCode = 500, $message = '"Internal server error."', $errors = null, $data = null): JsonResponse
    {
        if($errorCode == 0 || $errorCode == null){
            $errorCode = 500;
        }

        $response = [
            'message' => $message,
            'errors' => $errors,
            'data' => $data,
        ];

        return response()->json($response, $errorCode);
    }
}
