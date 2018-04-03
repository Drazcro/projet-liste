<?php

require_once (__DIR__."/params.php");
require_once (__DIR__."/Router.php");

\Autoloader::register();

$r = new Router();

$r->root();