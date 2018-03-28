<?php

namespace Controller;

use Exceptions\HttpException;

/**
 * Class ListeController
 * @package Controller
 * Gère les actions a effectuer sur les listes
 */
class ListeController extends HttpController
{
    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new \Model\ListeRepository();
    }

    public function action()
    {
        try {
            if(!isset($this->data['function']))
                throw new HttpException('Aucune fonction n\'a etee specifiee.');
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
            if($this->data['function'] == 'getAll') {

            }
            elseif ($this->data['function'] == 'getList') {
                if(isset($this->data['idListe']))
                    $d = $this->repository->getList($this->data['idListe']);
                else
                    throw new HttpException('L\'id n\'est pas indique.');
            }
            else
                throw new HttpException('La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        return $d;
    }

    private function post()
    {
            if($this->data['function'] == 'createListe') {
                if(isset($this->data['idUser']) && isset($this->data['description']) && isset($this->data['visibility']) && isset($this->data['title'])) {
                    $d = $this->repository->createList($this->data['idUser'], $this->data['description'], $this->data['visibility'], $this->data['title']);
                }
                else
                    throw new HttpException('Le title ou description ou visibility ou idUser n\'est pas definie.');
            }
            else {
                throw new HttpException('La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
            }
        if(!$d) {
            throw new HttpException('L\'ajout a echoue.');
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
        if($this->data['function'] == 'deleteListe') {
            if(isset($this->data['idListe'])) {
                $d = $this->repository->deleteList($this->data['idListe']);
            }
            else
                throw new HttpException('Le title ou description ou visibility ou idUser n\'est pas definie.');
        }
        else {
            throw new HttpException('La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        }
        if(!$d) {
            throw new HttpException('La suppression a echoue.');
        }
        else {
            return "La suppression a reussie.";
        }
    }

    private function update()
    {
        if($this->data['function'] == 'updateListe') {
            if(isset($this->data['idUser']) && isset($this->data['title']) && isset($this->data['description']) && isset($this->data['visibility']) && isset($this->data['idListe'])) {
                $d = $this->repository->updateListe($this->data['idUser'], $this->data['title'], $this->data['description'], $this->data['visibility'], $this->data['idListe']);
            }
            else
                throw new HttpException('Le title ou description ou visibility ou idUser ou idListe n\'est pas definie.');
        }
        else {
            throw new HttpException('La fonction '.$this->data['function'].' pour la table '.$this->data['table'].' n\'existe pas ou n\'est pas indiquee.');
        }
        if(!$d) {
            throw new HttpException('La mise a jour a echoue.');
        }
        else {
            return "La mise a jour reussie.";
        }
    }
}