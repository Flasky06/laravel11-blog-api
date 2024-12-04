<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function : Common to display success -JSON Response
     * @param string $status
     *@param string $message
     *@param string $data
     *@param integer $statusCode
     *@return response
     */
    public static function success($status = 'success', $message = null, $data = null, $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }

    /**
     * Function : Common to display error -JSON Response
     * @param string $status
     *@param string $message
     *@param integer $statusCode
     *@return response
     */
    public static function error($status = 'error', $message = null, $data = null, $statusCode = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ],$statusCode);
    }
}