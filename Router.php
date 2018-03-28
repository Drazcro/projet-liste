<?php

require_once ("Autoloader.php");

class Router
{
    public function root()
    {
        \Autoloader::register();
        try {
            $name = 'Controller\\'.$_REQUEST['table'].'Controller';
            $nameToTest = str_replace('\\', '/', $name).'.php';
            if(!file_exists($nameToTest)) {
                throw new \Exceptions\HttpException();
            }
            $controller = new $name($_SERVER['REQUEST_METHOD']);
            $controller->action();
        }
        catch (\Exceptions\HttpException $e) {
            $e->setResponse($_REQUEST['table']);
        }
    }
}