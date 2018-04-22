<?php

namespace Utils;

class HttpResponse {
    public function json_response($message = null, $code = 200)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($code);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            404 => '404 Not Found',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        // ok, validation error, or failure
        if(isset($status[$code]))
            header('Status: '.$status[$code]);
        // return the encoded json
        echo json_encode(array(
            'message' => $message
        ));
    }
}