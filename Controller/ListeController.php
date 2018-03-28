<?php

namespace Controller;

use Exceptions\HttpException;

require_once (DIR."/Autoloader.php");

class ListeController extends HttpController
{
    public function action()
    {
        \Autoloader::register();
        try {
            $r = new \Model\ListeRepository();
            $d = $r->get($this->data['id']);
            if($d == false)
                throw new HttpException();
            $this->httpResponse($d);
        }
        catch (HttpException $e) {
            $e->setResponse('Aucune liste appartenant à l\'utilisateur '.$this->data['id'].' n\'a été trouvé');
        }
    }
}