<?php

namespace App\Helpers;


class ApiFormatter
{
    protected static $response = [
        'kode'      => null,
        'status'    => null,
        'message'   => null,
        'data'      => null
    ];

    public static function createApi($code = null, $status = null, $message = null, $data = null)
    {
        self::$response['kode']     = $code;
        self::$response['status']   = $status;
        self::$response['message']  = $message;
        self::$response['data']     = $data;

        return response()->json(self::$response, self::$response['kode']);
    }
}
