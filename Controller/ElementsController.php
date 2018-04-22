<?php

namespace Controller;

use Exceptions\HttpException;

class ElementsController extends HttpController
{
    public function __construct($getData, $postData, $url, $method, $pseudo, $password)
    {
        parent::__construct($getData, $postData, $url, $method, $pseudo, $password);
        $this->repository = new \Model\ElementModel();
    }

    /**
     * Min url : GET /elements
     * @return mixed
     * @throws HttpException
     */
    public function get()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
        //url : GET /elements/{id}
        if(preg_match('#^/elements/(\d)*$#', $this->url))
            $d = $this->repository->getElement($id);
        else
            throw new HttpException(400,'L\'appel n\'est pas reconnu. Il se peut que le format soit errone.');
        if($d == false)
            throw new HttpException(400, 'Aucune ligne selectionnee.');
        return $d;
    }

    /**
     * url : POST /elements + POST params
     * @return string
     * @throws HttpException
     */
    public function post()
    {
        if(isset($this->postData['date_creation']) && isset($this->postData['date_modif']) && isset($this->postData['titre']) && isset($this->postData['description']) && isset($this->postData['statut']) && isset($this->postData['idListe']))
            $d = $this->repository->createElement($this->postData['date_creation'], $this->postData['date_modif'], $this->postData['titre'], $this->postData['description'], $this->postData['statut'], $this->postData['idListe']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(400, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /elements/{id]
     * @return string
     * @throws HttpException
     */
    public function delete()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
        if(isset($id) && !empty($id))
            $d = $this->repository->deleteElement($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(400, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT /elements/{id} + PUT params
     * @return string
     * @throws HttpException
     */
    public function put()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
        if(isset($this->postData['date_creation']) && isset($this->postData['date_modif']) && isset($this->postData['titre']) && isset($this->postData['description']) && isset($this->postData['statut']) && isset($this->postData['idListe']) && isset($id) && !empty($id))
            $d = $this->repository->updateElement($this->postData['date_creation'], $this->postData['date_modif'], $this->postData['titre'], $this->postData['description'], $this->postData['statut'], $this->postData['idListe'], $id);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(400, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}