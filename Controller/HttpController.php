<?php

namespace Controller;

use Utils\HttpResponse;

require_once (DIR."/Autoloader.php");

abstract class HttpController
{
    protected $method;
    protected $data;

    public function __construct () {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $_REQUEST;
    }

    abstract function action();

    public function httpResponse($message)
    {
        \Autoloader::register();
        $r = new HttpResponse();
        $r->json_response($message);
    }
}