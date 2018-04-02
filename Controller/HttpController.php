<?php

namespace Controller;

use Utils\HttpResponse;

abstract class HttpController
{
    protected $method;
    protected $getData;
    protected $postData;
    protected $table;
    protected $urlData;

    public function __construct ($getData, $postData, $method) {
        $this->method = $method;
        $this->getData = $getData;
        $this->postData = $postData;
    }

    public function httpResponse($message)
    {
        $r = new HttpResponse();
        $r->json_response($message);
    }
}