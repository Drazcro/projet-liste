<?php

namespace Exceptions;

class HttpException extends \Exception
{
    public function setResponse($code = 404) {
        $r = new \Utils\HttpResponse();
        $r->json_response($this->message, $code);
    }
}