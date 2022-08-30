<?php

namespace App\Http\Helpers;

class ResponseHelper{

    public static function success($message=null, $data=null, $extend=null){
        if(! is_string($message)){
            if(is_array($data)){
                $extend = $data;
            }

            $data = $message;
            $message = null;
        }

        if($message){
            $payload['message'] = $message;
        }

        $payload['data'] = $data;

        if($extend){
            $payload = array_merge($payload, $extend);
        }

        return response($payload)->setStatusCode(200);
    }

    public static function error($message=null, $errors=null){
        $payload = [
            'message'   => $message,
            'errors'    => $errors
        ];

        return response($payload)->setStatusCode(400);
    }
}
