<?php

namespace Controller;

use Exceptions\HttpException;

class UtilisateurController extends HttpController
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new \Model\UtilisateurRepository();
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
                $d=$this->update();
            }
            $this->httpResponse($d);
        }
        catch (HttpException $e) {
            $e->setResponse();
        }
    }

    private function get()
    {
        if ($this->data['function'] == 'getUtilisateur') {
            if(isset($this->data['idUser']))
                $d = $this->repository->getUtilisateur($this->data['idUser']);
            else
                throw new HttpException(400, 'L\'id n\'est pas indique.');
        }
        else
            throw new HttpException(400, 'La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        return $d;
    }

    private function post()
    {
        if($this->data['function'] == 'createUtilisateur') {
            if(isset($this->data['pseudo']) && isset($this->data['password']) && isset($this->data['permission']) && isset($this->data['role'])) {
                $d = $this->repository->createUtilisateur($this->data['pseudo'], $this->data['password'], $this->data['permission'], $this->data['role']);
            }
            else
                throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
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

    private function put()
    {
        // TODO: Implement put() method.
    }

    private function delete()
    {
        if($this->data['function'] == 'deleteUtilisateur') {
            if(isset($this->data['idUser'])) {
                $d = $this->repository->deleteUtilisateur($this->data['idUser']);
            }
            else
                throw new HttpException(400, 'L\'idUser n\'est pas definie.');
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

    private function update()
    {
        if($this->data['function'] == 'updateUtilisateur') {
            if(isset($this->data['pseudo']) && isset($this->data['password']) && isset($this->data['permission']) && isset($this->data['role']) && isset($this->data['idUser'])) {
                $d = $this->repository->updateUtilisateur($this->data['pseudo'], $this->data['password'], $this->data['permission'], $this->data['role'], $this->data['idUser']);
            }
            else
                throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
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