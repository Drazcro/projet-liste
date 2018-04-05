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
    private $logger;
    private $url;

    public function __construct()
    {
        $this->logger = new \Log\Logger();
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ('PUT' == $this->method || 'DELETE' == $this->method)
                parse_str(file_get_contents('php://input'), $_REQUEST);
        $this->setData();
        $this->table = ucfirst(strtolower($this->getData[0]));
    }

    /**
     * Route la requete vers le bon controlleur
     */
    public function root()
    {
        $this->logger->log($this->method, $this->table, $this->getData, $this->postData);
        try {
            if(empty($this->table))
                $this->table='Page';
            $name = 'Controller\\'.$this->table.'Controller';
            $nameToTest = str_replace('\\', '/', $name).'.php';
            if(!file_exists($nameToTest))
                throw new \Exceptions\HttpException(400, 'La table '.$this->table.' n\'existe pas.');
            $controller = new $name($this->getData, $this->postData, $this->url, $this->method);
            $controller->action();
        }
        catch (\Exceptions\HttpException $e) {
            $e->setResponse();
        }
    }

    /**
     * Prépare les données de la requête pour les controlleurs
     */
    private function setData() {
        if(isset($_SERVER['PATH_INFO'])) {
            $url = explode('/', $_SERVER['PATH_INFO']);
            $this->url = $_SERVER['PATH_INFO'];
            $this->getData = array_splice($url, 1);
        }
        //Adapatation alwaysdata
        elseif(isset($_SERVER['ORIG_PATH_INFO'])) {
            $url = explode('/', $_SERVER['ORIG_PATH_INFO']);
            $this->url = $_SERVER['ORIG_PATH_INFO'];
            $this->getData = array_splice($url, 1);
        }
        $this->postData = $_REQUEST;
    }
}