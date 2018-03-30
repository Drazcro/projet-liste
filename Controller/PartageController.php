<?php

namespace Controller;

use Exceptions\HttpException;

class PartageController extends HttpController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new \Model\PartageRepository();
    }

    public function action()
    {
        try {
            if(!isset($this->data['function']))
                throw new HttpException(400, 'Aucune fonction n\'a etee specifiee.');
            if($this->method == 'GET') {
                $d=$this->get();
            }
            elseif ($this->method == 'POST') {
                $d=$this->post();
            }
            elseif ($this->method == 'DELETE') {
                $d=$this->delete();
            }
            elseif ($this->method == 'PUT') {
                $d=$this->put();
            }
            $this->httpResponse($d);
        }
        catch (HttpException $e) {
            $e->setResponse();
        }
    }

    private function get()
    {
        if ($this->data['function'] == 'getPartage') {
            if(isset($this->data['utilisateur_idUser']) && isset($this->data['liste_idListe']))
                $d = $this->repository->getPartage($this->data['utilisateur_idUser'], $this->data['liste_idListe']);
            else
                throw new HttpException(400, 'L\'id n\'est pas indique.');
        }
        else
            throw new HttpException(400, 'La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        return $d;
    }

    private function post()
    {
        if($this->data['function'] == 'createPartage') {
            if(isset($this->data['utilisateur_idUser']) && isset($this->data['liste_idliste']) && isset($this->data['autorisation'])) {
                $d = $this->repository->createPartage($this->data['utilisateur_idUser'], $this->data['liste_idliste'], $this->data['autorisation']);
            }
            else
                throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        }
        else {
            throw new HttpException(400, 'La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        }
        if(!$d) {
            throw new HttpException(500, 'L\'ajout a echoue.');
        }
        else {
            return "L\'ajout a reussie.";
        }
    }

    private function delete()
    {
        if($this->data['function'] == 'deletePartage') {
            if(isset($this->data['utilisateur_idUser']) && isset($this->data['liste_idliste'])) {
                $d = $this->repository->deletePartage($this->data['utilisateur_idUser'], $this->data['liste_idliste']);
            }
            else
                throw new HttpException(400, 'L\'id n\'est pas definie.');
        }
        else {
            throw new HttpException(400, 'La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        }
        if(!$d) {
            throw new HttpException(500, 'La suppression a echoue.');
        }
        else {
            return "La suppression a reussie.";
        }
    }

    private function put()
    {
        if($this->data['function'] == 'updatePartage') {
            if(isset($this->data['utilisateur_idUser']) && isset($this->data['liste_idliste']) && isset($this->data['autorisation'])) {
                $d = $this->repository->updatePartage($this->data['utilisateur_idUser'], $this->data['liste_idliste'], $this->data['autorisation']);
            }
            else
                throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        }
        else {
            throw new HttpException(400, 'La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        }
        if(!$d) {
            throw new HttpException(500, 'La mise a jour a echoue.');
        }
        else {
            return "La mise a jour reussie.";
        }
    }
}