<?php

require_once ("Autoloader.php");

/**
 * Class Router
 * Va inclure le controlleur approprié.
 */
class Router
{
    private $getData;
    private $postData;
    private $method;
    private $table;

    public function __construct()
    {
            $this->method = $_SERVER['REQUEST_METHOD'];
            if ('PUT' == $this->method || 'DELETE' == $this->method)
                parse_str(file_get_contents('php://input'), $_REQUEST);
            $this->setData();
            $this->table = ucfirst(strtolower($this->getData[0]));
    }

    public function root()
    {
        try {
            if(!isset($this->table) && !empty($this->table))
                throw new \Exceptions\HttpException(404, 'Je dois faire quoi ?');
            $name = 'Controller\\'.$this->table.'Controller';
            $nameToTest = str_replace('\\', '/', $name).'.php';
            if(!file_exists($nameToTest))
                throw new \Exceptions\HttpException(400, 'La table '.$this->table.' n\'existe pas.');
            $controller = new $name($this->getData, $this->postData, $this->method);
            $controller->action();
        }
        catch (\Exceptions\HttpException $e) {
            $e->setResponse();
        }
    }

    private function setData() {
        if(isset($_SERVER['PATH_INFO'])) {
            $url = explode('/', $_SERVER['PATH_INFO']);
            $this->getData = array_splice($url, 1);
            $this->postData = $_REQUEST;
        }
    }
}