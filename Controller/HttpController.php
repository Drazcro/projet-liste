<?php

namespace Controller;

use Utils\HttpResponse;

require_once (DIR."/Autoloader.php");

class HttpController implements ControllerInterface
{
    protected $method;
    protected $data;

    public function __construct () {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $_REQUEST;
    }

    public function action()
    {
        // TODO: Implement action() method.
    }

    public function httpResponse($message)
    {
        \Autoloader::register();
        $r = new HttpResponse();
        $r->json_response($message);
    }
}