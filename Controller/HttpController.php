<?php

namespace Controller;

use Utils\HttpResponse;

abstract class HttpController
{
    protected $method;
    protected $getData;
    protected $postData;
    protected $urlData;
    protected $url;

    public function __construct ($getData, $postData, $url, $method) {
        $this->method = $method;
        $this->getData = $getData;
        $this->postData = $postData;
        $this->url = $url;
    }

    public function httpResponse($message)
    {
        $r = new HttpResponse();
        $r->json_response($message);
    }
}