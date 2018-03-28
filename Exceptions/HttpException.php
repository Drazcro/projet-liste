<?php

namespace Exceptions;

require_once (DIR."/Autoloader.php");

class HttpException extends \Exception
{
    public function setResponse($table, $code = 404) {
        $r = new \Utils\HttpResponse();
        $r->json_response("The table $table doesn't exits.", $code);
    }
}