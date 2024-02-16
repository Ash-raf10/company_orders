<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * SendResponse send json response
     *
     * @param bool        $status     true/false
     * @param mixed $data     data or result
     * @param array|string $message    message to show to the user
     * @param int         $statusCode http status codes
     * @param int         $internalCode for our use
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(
        bool $status = true,
        mixed $data = "",
        array|string $message = "",
        int $statusCode = 200,
        $internalCode = 0000
    ) {
        $response = [
            'success' => $status,
            'data'    => $data,
            'message' => $message,
            'code' => $internalCode
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * SendResponse for pagination on list page
     *
     * @param mixed $data data or result
     * @param array $pagination pagination information
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPaginationResponse(mixed $data, array $pagination)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'pagination' => $pagination,
            'message' => "",
            'code' => 0
        ];

        return response()->json($response, 200);
    }
}