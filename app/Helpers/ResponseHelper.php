<?php

namespace App\Helpers;

class ResponseHelper{

    public static function response($status,$message, $data = [])
    {
        return response()->json([
            'status' => $status,
            'message'=>$message,
            'data' => $data
        ]);
    }

}
