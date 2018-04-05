<?php

require_once (__DIR__."/params.php");
require_once (__DIR__."/Router.php");

\Autoloader::register();

$r = new Router();

try {
    $r->root();
}
catch(\Exception $e) {
    $he = new \Exceptions\HttpException('500', 'Une erreur inatendue est survenue. Veuillez réessayer.');
    $he->setResponse();
}

