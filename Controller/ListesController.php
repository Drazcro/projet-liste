<?php

namespace Controller;

use Exceptions\HttpException;

/**
 * Class ListesController
 * @package Controller
 * Gère les actions a effectuer sur les listes
 */
class ListesController extends HttpController
{
    private $repository;

    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\ListeRepository();
    }

    public function action()
    {
        if($this->method == 'GET')
            $d=$this->get();
        elseif ($this->method == 'POST')
            $d=$this->post();
        elseif ($this->method == 'DELETE')
            $d=$this->delete();
        elseif ($this->method == 'PUT')
            $d=$this->put();
        $this->httpResponse($d);
    }

    /**
     * min url : GET /listes
     * @return bool|mixed
     * @throws HttpException
     */
    private function get()
    {
        $id = $this->getData[1];
        //url : GET /listes
        if(sizeof($this->getData) == 1)
            $d = true;
        // url : GET /listes/{id}
        elseif(sizeof($this->getData) == 2 && isset($id) && !empty($id))
            $d = $this->repository->getListe($id);
        else
            throw new HttpException(400,'L\'id n\'est pas bien défini ou n\'est pas fourni.');
        return $d;
    }

    /**
     * url : POST /listes + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {
        if(isset($this->postData['idUser'])
            && isset($this->postData['description'])
            && isset($this->postData['visibility'])
            && isset($this->postData['title'])) {
            $d = $this->repository->createListe($this->postData['idUser'], $this->postData['description'], $this->postData['visibility'], $this->postData['title']);
        }
        else
            throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /listes/{id}
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $id = $this->getData[1];
        if(isset($id) && !empty($id))
            $d = $this->repository->deleteListe($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : UPDATE /listes/{id} + POST params
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $id = $this->getData[1];
        if(isset($this->postData['idUser']) && isset($this->postData['title']) && isset($this->postData['description']) && isset($this->postData['visibility']) && isset($id) && !empty($id))
            $d = $this->repository->updateListe($this->postData['idUser'], $this->postData['title'], $this->postData['description'], $this->postData['visibility'], $id);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}