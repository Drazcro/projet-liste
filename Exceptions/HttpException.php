<?php

namespace Exceptions;

class HttpException extends \Exception
{
    public function __construct($code, $message)
    {
        parent::__construct();
        $this->code = $code;
        $this->message = $message;
    }

    public function setResponse() {
        $r = new \Utils\HttpResponse();
        $r->json_response($this->message, $this->code);
    }
}