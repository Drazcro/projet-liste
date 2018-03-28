<?php

require_once ("Autoloader.php");

/**
 * Class Router
 * Va inclure le controlleur approprié.
 */
class Router
{
    public function root()
    {
        \Autoloader::register();
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ('PUT' == $method) {
                parse_str(file_get_contents('php://input'), $_REQUEST);
            }
            else if('DELETE' == $method) {
                parse_str(file_get_contents('php://input'), $_REQUEST);
            }
            if(!isset($_REQUEST['table']) && !isset($_PUT['table']) && !isset($_DELETE['table']))
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