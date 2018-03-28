<?php


define('DIR', preg_replace("#/main.php$#", "", $_SERVER['SCRIPT_FILENAME']));

require_once (DIR."/params.php");
require_once (DIR."/Router.php");

$r = new Router();

$r->root();