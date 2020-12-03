<?php
/**
 * Created by PhpStorm.
 * User: garo
 * Date: 12/3/20
 * Time: 10:39 PM
 */

namespace App\Http\Controllers;


class ApiController extends Controller
{
    /**
     * @param $data
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    function successResponse($data, $msg = null) {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $msg
        ]);
    }

    /**
     * @param $data
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     */
    function errorResponse($msg, $details = null, $statusCode) {
        return response()->json([
            'status' => 'error',
            'message' => $msg,
            'details' => $details
        ], $statusCode);
    }

}
