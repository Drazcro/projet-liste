<?php

class Autoloader
{
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class){
        $path = str_replace('\\', '/', $class);
        //var_dump($path);
        require_once $path . '.php';
    }
}