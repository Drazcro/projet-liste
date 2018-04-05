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

    public function __construct($getData, $postData, $url, $method)
    {
        parent::__construct($getData, $postData, $url, $method);
        $this->repository = new \Model\ListeRepository();
    }

    /**
     * min url : GET /listes
     * @return bool|mixed
     * @throws HttpException
     */
    public function get()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
        //url : GET /listes
        if(preg_match('#^/listes$#', $this->url))
            $d = $this->repository->getAllListe();
        // url : GET /listes/{id}
        elseif(preg_match('#^/listes/(\d)+$#', $this->url))
            $d = $this->repository->getListe($id);
        //url : GET /listes/{idListe}/elements
        elseif(preg_match('#^/listes/(\d)+/elements$#', $this->url))
            $d = $this->repository->getElements($this->getData[1]);
        //url : GET /listes/all/{idUser}
        elseif(preg_match('#^/listes/all/(\d)+$#', $this->url))
            $d = $this->repository->getAllListe($this->getData[2]);
        else
            throw new HttpException(400,'L\'appel n\'est pas reconnu. Il se peut que le format soit errone.');
        if($d == false)
            throw new HttpException(404, 'Aucune ligne selectionnee.');
        return $d;
    }

    /**
     * url : POST /listes + POST params
     * @return string
     * @throws HttpException
     */
    public function post()
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
    public function delete()
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
     * url : UPDATE /listes/{id} + PUT params
     * @return string
     * @throws HttpException
     */
    public function put()
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