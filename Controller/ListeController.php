<?php

namespace Controller;

use Exceptions\HttpException;

class ListeController extends HttpController
{
    public function action()
    {
        try {
            $r = new \Model\ListeRepository();
            if($this->data['function'] == 'getAll') {

            }
            elseif ($this->data['function'] == 'getList') {
                if(isset($this->data['id']))
                    $d = $r->get($this->data['id']);
                else
                    throw new HttpException('L\'id n\'est pas indique.');
            }
            else
                throw new HttpException('La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
            if($d == false)
                throw new HttpException('Aucune liste appartenant à l\'utilisateur '.$this->data['id'].' n\'a été trouve.');
            $this->httpResponse($d);
        }
        catch (HttpException $e) {
            $e->setResponse();
        }
    }
}