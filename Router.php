<?php

require_once ("Autoloader.php");

class Router
{
    public function root()
    {
        \Autoloader::register();
        try {
            if(!isset($_REQUEST['table']))
                throw new \Exceptions\HttpException('Je dois faire quoi ?');
            $name = 'Controller\\'.$_REQUEST['table'].'Controller';
            $nameToTest = str_replace('\\', '/', $name).'.php';
            if(!file_exists($nameToTest)) {
                throw new \Exceptions\HttpException('La table '.$_REQUEST['table'].' n\'existe pas');
            }
            $controller = new $name($_SERVER['REQUEST_METHOD']);
            $controller->action();
        }
        catch (\Exceptions\HttpException $e) {
            $e->setResponse();
        }
    }
}