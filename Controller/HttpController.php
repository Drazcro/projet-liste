<?php

namespace Controller;

use Utils\HttpResponse;

require_once (DIR."/Autoloader.php");

abstract class HttpController
{
    protected $method;
    protected $data;
    //protected $fields;

    public function __construct () {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $_REQUEST;
    }

    public function httpResponse($message)
    {
        \Autoloader::register();
        $r = new HttpResponse();
        $r->json_response($message);
    }

    /*protected function testIsset() {
        foreach ($this->fields as $f) {
            if(!isset($data[$f]))
                return false;
        }
        return true;
    }*/
}